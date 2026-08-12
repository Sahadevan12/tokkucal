import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/tools/gst-calculator.js',
                'resources/js/tools/emi-calculator.js',
                'resources/js/tools/percentage-calculator.js',
                'resources/js/tools/age-calculator.js',
                'resources/js/tools/salary-calculator.js',
                'resources/js/tools/discount-calculator.js',
                'resources/js/tools/attendance-calculator.js',
                'resources/js/tools/image-compressor.js',
                'resources/js/tools/image-resizer.js',
                'resources/js/tools/qr-generator.js',
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
