import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',  // Include your CSS or SCSS here
                'resources/js/app.js',
                'resources/fonts/linearicons/style.css',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (/\.(gif|jpe?g|png|svg)$/.test(assetInfo.name)) {
                        return 'images/[name][extname]';  // Output images in public/images
                    }

                    if (/\.(woff2?|eot|ttf|otf)$/.test(assetInfo.name)) {
                        return 'fonts/[name][extname]';  // Output fonts in public/fonts
                    }

                    return '[name][extname]';
                },
            },
        },
    },
});
