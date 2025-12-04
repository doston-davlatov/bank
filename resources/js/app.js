// resources/js/app.js — Vite uchun faqat frontend!
import '../css/app.css';
import './bootstrap';

console.log('Laravel + Vite frontend ishlayapti!');

// Agar kerak bo‘lsa: Alpine, Axios va h.k.
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
