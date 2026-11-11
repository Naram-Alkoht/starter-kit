import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { defineConfig, lazyPlugins } from 'vite-plus';

// Built assets (committed) and vendor-published assets.
const generated = ['public/build/**', 'public/css/**', 'public/js/**'];

export default defineConfig({
    fmt: {
        singleQuote: true,
        // Composer and bun rewrite these themselves.
        ignorePatterns: [...generated, 'composer.json', 'package.json'],
    },
    lint: {
        ignorePatterns: generated,
    },
    plugins: lazyPlugins(() => [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ]),
    server: {
        cors: true,
        watch: {
            ignored: [
                '**/.agents/**',
                '**/.claude/**',
                '**/.cursor/**',
                '**/.junie/**',
                '**/storage/framework/views/**',
                '**/vendor/**',
            ],
        },
    },
});
