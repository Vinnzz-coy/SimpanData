import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/auth.js',
                'resources/css/admin/dashboard.css',
                'resources/js/admin/dashboard.js',
                'resources/css/admin/peserta.css',
                'resources/js/admin/peserta.js',
                'resources/css/sidebar.css',
                'resources/js/sidebar.js',
                'resources/js/peserta/absensi.js',
                'resources/js/peserta/laporan.js',
                'resources/js/admin/laporan.js',
                'resources/js/admin/penilaian.js',
                'resources/js/index.js',
                'resources/js/landing.js'
            ],
            refresh: true,
        }),
    ],
});
