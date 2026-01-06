import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/js/app.js',
                'resources/js/products_list.js',
                'resources/js/products_list_with_filters.js',
                'resources/js/checkout/stripe.js'],
            refresh: true,
        }),
    ],
});
