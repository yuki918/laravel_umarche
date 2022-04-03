const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            width: {
              "48/100": "48%",
              "24/100": "24%",
              "5/100": "5%",
              "3/9": "30%",
              "6/5": "120%",
              "7/5": "140%",
              "8/5": "160%",
              "9/5": "180%",
              "10/5": "200%",
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
