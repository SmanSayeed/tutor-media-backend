import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin/app.css',
                'resources/js/admin/app.js',
                'resources/js/admin/custom/analytics.js',
                'resources/css/user/app.css',
                'resources/js/user/app.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
