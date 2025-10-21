import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-red-500',
        'bg-orange-400',
        'bg-yellow-400',
        'bg-green-400',
        'bg-green-600'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Primary brand colors
                primary: {
                    500: '#8b5cf6',
                    600: '#7c3aed',
                    700: '#6d28d9',
                }
            }
        },
    },

    plugins: [forms, typography],
};