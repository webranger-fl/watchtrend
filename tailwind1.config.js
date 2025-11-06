import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    //content: [
    //    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    //    './storage/framework/views/*.php',
    //    './resources/views/**/*.blade.php',
    //],
    content: {
      files: [ './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php', './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
      ],
      extract: {
        wtf: (content) => {
          //return true;
          return !content.match(/<x-app-layout>/g)
        }
      }
    },

    theme: {
      fontFamily: {
        'golos': ['"Golos Text"'],
      },
        extend: {
          colors: {
            primary: '#fb5f4c',
            secondary: '#39BC5B'
          },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
