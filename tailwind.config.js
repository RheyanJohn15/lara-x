/** @type {import('tailwindcss').Config} */
export default {
    darkMode: ['selector', '[class*="app-dark"]'],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],
      plugins: [require('tailwindcss-primeui')],
  theme: {
    screens: {
        sm: '576px',
        md: '768px',
        lg: '992px',
        xl: '1200px',
        '2xl': '1920px'
    },
    extend: {},
  },
  plugins: [],
}

