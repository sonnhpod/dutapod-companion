/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './includes/template/*.php',
    './includes/template/**/*.php',
    './sources/scope-frontend/*.scss',
    './sources/scope-frontend/**/*.scss'
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

