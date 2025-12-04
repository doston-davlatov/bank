// server.js — To'liq Node.js/Express + SQLite Banking API
import express from 'express';
import sqlite3 from 'sqlite3';
import jwt from 'jsonwebtoken';
import bcrypt from 'bcryptjs';
import bodyParser from 'body-parser';
import cors from 'cors';
import rateLimit from 'express-rate-limit';

const app = express();
const PORT = 8000;
const JWT_SECRET = 'bank_super_secret_key_2025';

// Middleware
app.use(bodyParser.json());
app.use(cors({
    origin: 'http://127.0.0.1:8000',
    credentials: true
}));
app.use(rateLimit({ windowMs: 15 * 60 * 1000, max: 100 }));

// Database
const db = new sqlite3.Database('./bank.db', (err) => {
    if (err) console.error('DB xato:', err);
    else {
        console.log('bank.db ulandi');
        initDB();
    }
});

function initDB() {
    db.serialize(() => {
        const tables = [
            `CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )`,
            `CREATE TABLE IF NOT EXISTS accounts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER,
                account_number TEXT UNIQUE NOT NULL,
                balance REAL DEFAULT 0,
                type TEXT DEFAULT 'savings',
                FOREIGN KEY (user_id) REFERENCES users(id)
            )`,
            `CREATE TABLE IF NOT EXISTS transactions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                account_id INTEGER,
                type TEXT,
                amount REAL,
                description TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )`
        ];
        tables.forEach(sql => db.run(sql));
    });
}

// JWT middleware
const authenticate = (req, res, next) => {
    const token = req.headers.authorization?.split(' ')[1];
    if (!token) return res.status(401).json({ error: 'Token yo‘q' });

    jwt.verify(token, JWT_SECRET, (err, user) => {
        if (err) return res.status(403).json({ error: 'Noto‘g‘ri token' });
        req.user = user;
        next();
    });
};

// Routes
app.get('/', (req, res) => res.json({ message: 'Bank API ishlayapti!' }));

app.post('/api/register', async (req, res) => {
    const { username, password, email } = req.body;
    const hash = bcrypt.hashSync(password, 10);

    db.run('INSERT INTO users (username, password, email) VALUES (?, ?, ?)', [username, hash, email], function(err) {
        if (err) return res.status(400).json({ error: err.message });
        const accNum = `ACC${this.lastID}${Math.floor(1000 + Math.random() * 9000)}`;
        db.run('INSERT INTO accounts (user_id, account_number, balance) VALUES (?, ?, 0)', [this.lastID, accNum]);
        res.json({ message: 'Ro‘yxatdan o‘tildi', userId: this.lastID });
    });
});

app.post('/api/login', (req, res) => {
    const { username, password } = req.body;
    db.get('SELECT * FROM users WHERE username = ?', [username], (err, user) => {
        if (!user || !bcrypt.compareSync(password, user.password))
            return res.status(401).json({ error: 'Login yoki parol xato' });

        const token = jwt.sign({ id: user.id, username: user.username }, JWT_SECRET, { expiresIn: '24h' });
        res.json({ token, user: { id: user.id, username: user.username } });
    });
});

app.get('/api/accounts', authenticate, (req, res) => {
    db.all('SELECT * FROM accounts WHERE user_id = ?', [req.user.id], (err, rows) => {
        if (err) return res.status(500).json({ error: err.message });
        res.json(rows);
    });
});

// Qo‘shimcha API lar keyinroq qo‘shiladi...

app.listen(PORT, () => {
    console.log(`Backend API: http://localhost:${PORT}`);
});
