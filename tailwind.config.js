/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './**/*.{html,js,php}'
  ],
  safelist: [
    'grid', 'grid-cols-12', 'col-span-3', 'col-span-6', 'col-start-9'
  ],
  theme: {
    extend: {},
  },
  corePlugins: {
    preflight: true
  },
  plugins: [],
}

/** Original content 
    './includes/template/*.php',
    './includes/template/** '/*.php',
    './sources/scope-frontend/*.scss',
    './sources/scope-frontend/** '/*.scss'
*/