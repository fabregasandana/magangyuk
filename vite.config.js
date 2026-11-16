import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/pembimbing.css',
                'resources/css/peserta.css',
                'resources/css/landing.css',
                'resources/css/login.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/pembimbing.js',
                'resources/js/peserta.js',
                'resources/js/landing.js',
                'resources/js/login.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
