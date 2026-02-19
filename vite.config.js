import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/public/public.css',
                'resources/css/public/dashboard.css',
                'resources/css/auth/login.css',
                'resources/css/auth/forgot-password.css',
                'resources/js/profile/index.js',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
    ],
});
