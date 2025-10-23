import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                 'resources/js/app.js',
                 'resources/js/echo.js',
                 'resources/css/auth/login.css',
                 'resources/css/auth/register.css',
                 'resources/js/auth/login.js',
                 'resources/js/auth/register.js'],
            refresh: true,
        }),
    ],
});
