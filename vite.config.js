import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Certifique-se de que o caminho está correto
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});