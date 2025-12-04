import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            // Backend paketlarini brauzerga yuklamaslik uchun
            external: [
                'express',
                'express-rate-limit',
                'sqlite3',
                'jsonwebtoken',
                'bcrypt',
                'dotenv',
                'cors',
                'morgan',
                'helmet',
                // Qo'shimcha backend paketlari bo'lsa, shu yerga qo'shing
            ]
        }
    },
    // Node.js built-in modullarini ham external qilish
    resolve: {
        alias: {
            // Agar app.js da node modullari import qilinsa
            // masalan: import fs from 'fs'; → xato beradi
        }
    }
});
