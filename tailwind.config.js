const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'page': {
                    'bg': '#20222b',
                    'text': '#f8f9fa',
                },
                'table': {
                    'bg': '#2a2e37',
                    'header': '#343a40',
                    'text': '#f8f9fa',
                    'border': '#474f58',
                },
                'badge': {
                    'redeemed': '#6c757d',
                    'new': '#28a745',
                    'text': '#ffffff',
                },
                'btn': {
                    'primary': '#0d6efd',
                    'info': '#17a2b8',
                    'danger': '#dc3545',
                    'warning': '#ffc107',
                    'text': {
                        'light': '#ffffff',
                        'dark': '#212529',
                    }
                },
                'pagination': {
                    'bg': '#343a40',
                    'hover': '#4a5568',
                    'active': '#0d6efd',
                    'text': '#f8f9fa',
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
