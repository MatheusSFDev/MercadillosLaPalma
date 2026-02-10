import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'playfair': ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
                'dm-serif': ['"DM Serif Display"', ...defaultTheme.fontFamily.serif],
                'atkinson': ['"Atkinson Hyperlegible"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
