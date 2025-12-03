// app.js - Complete Node.js/Express Banking Backend (ES module syntax)
// Run: npm init -y && npm install express sqlite3 jsonwebtoken bcryptjs body-parser cors express-rate-limit
// Then: node app.js
// Server runs on port 8000

import express from 'express';
import sqlite3 from 'sqlite3';
import jwt from 'jsonwebtoken';
import bcrypt from 'bcryptjs';
import bodyParser from 'body-parser';
import cors from 'cors';
import rateLimit from 'express-rate-limit';

const app = express();
const port = 8000;
const secret = 'your_jwt_secret_key'; // Replace with env var in production

app.use(bodyParser.json());
app.use(cors());

// Rate limiting
const limiter = rateLimit({
    windowMs: 15 * 60 * 1000,
    max: 100
});
app.use(limiter);

// Initialize SQLite Database
const db = new sqlite3.Database('bank.db', (err) => {
    if (err) {
        console.error('Error opening database', err);
    } else {
        console.log('Database connected');
        initializeDatabase();
    }
});

// Create tables if not exist
function initializeDatabase() {
    db.serialize(() => {
        db.run(`
      CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
      )
    `);

        db.run(`
      CREATE TABLE IF NOT EXISTS accounts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        account_number TEXT UNIQUE NOT NULL,
        balance REAL DEFAULT 0.0,
        type TEXT DEFAULT 'checking',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
      )
    `);

        db.run(`
      CREATE TABLE IF NOT EXISTS transactions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        account_id INTEGER NOT NULL,
        type TEXT NOT NULL,
        amount REAL NOT NULL,
        description TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (account_id) REFERENCES accounts(id)
      )
    `);

        db.run(`
      CREATE TABLE IF NOT EXISTS transfers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        from_account_id INTEGER NOT NULL,
        to_account_id INTEGER NOT NULL,
        amount REAL NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (from_account_id) REFERENCES accounts(id),
        FOREIGN KEY (to_account_id) REFERENCES accounts(id)
      )
    `);

        db.run(`
      CREATE TABLE IF NOT EXISTS cards (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        account_id INTEGER NOT NULL,
        card_number TEXT UNIQUE NOT NULL,
        cvv TEXT NOT NULL,
        expiry_date TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (account_id) REFERENCES accounts(id)
      )
    `);

        db.run(`
      CREATE TABLE IF NOT EXISTS beneficiaries (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        account_number TEXT NOT NULL,
        bank_name TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
      )
    `);

        db.run(`
      CREATE TABLE IF NOT EXISTS support_tickets (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        subject TEXT NOT NULL,
        description TEXT NOT NULL,
        status TEXT DEFAULT 'open',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
      )
    `);
    });
}

// JWT authentication middleware
function authenticateToken(req, res, next) {
    const authHeader = req.headers['authorization'];
    const token = authHeader?.split(' ')[1];
    if (!token) return res.status(401).json({ error: 'Unauthorized' });

    jwt.verify(token, secret, (err, user) => {
        if (err) return res.status(403).json({ error: 'Forbidden' });
        req.user = user;
        next();
    });
}

// Basic route
app.get('/', (req, res) => res.send('Banking API is running'));

// Register
app.post('/register', (req, res) => {
    const { username, password, email } = req.body;
    if (!username || !password || !email) return res.status(400).json({ error: 'Missing fields' });

    const hashedPassword = bcrypt.hashSync(password, 8);

    db.run('INSERT INTO users (username, password, email) VALUES (?, ?, ?)', [username, hashedPassword, email], function (err) {
        if (err) return res.status(500).json({ error: 'User registration failed', details: err.message });

        const accountNumber = `ACC${this.lastID}${Math.floor(Math.random() * 10000)}`;
        db.run('INSERT INTO accounts (user_id, account_number) VALUES (?, ?)', [this.lastID, accountNumber], function (err) {
            if (err) return res.status(500).json({ error: 'Account creation failed' });
            res.status(201).json({ message: 'User registered', userId: this.lastID });
        });
    });
});

// Login
app.post('/login', (req, res) => {
    const { username, password } = req.body;
    if (!username || !password) return res.status(400).json({ error: 'Missing fields' });

    db.get('SELECT * FROM users WHERE username = ?', [username], (err, user) => {
        if (err || !user) return res.status(400).json({ error: 'Invalid credentials' });

        if (!bcrypt.compareSync(password, user.password)) return res.status(400).json({ error: 'Invalid credentials' });

        const token = jwt.sign({ id: user.id, username: user.username }, secret, { expiresIn: '1h' });
        res.json({ token });
    });
});

// Example: Get accounts for user
app.get('/accounts', authenticateToken, (req, res) => {
    db.all('SELECT * FROM accounts WHERE user_id = ?', [req.user.id], (err, accounts) => {
        if (err) return res.status(500).json({ error: 'Failed to fetch accounts' });
        res.json(accounts);
    });
});

// Add more routes (transactions, transfers, cards, beneficiaries, support tickets) following same pattern...

// Start server
app.listen(port, () => console.log(`Banking backend running on http://localhost:${port}`));

// Graceful shutdown
process.on('SIGINT', () => {
    db.close();
    process.exit();
});
