import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.css',
        './resources/**/*.vue',
    ],
    darkMode: 'class', // Mantendo darkMode fora do objeto theme
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                londrina: ['Londrina Solid', 'sans-serif'],
            },
            invert: {
                25: '.25',
                50: '.5',
                75: '.75',
            },
        },
    },
    plugins: [], 
};