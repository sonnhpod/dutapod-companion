/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './**/*.{html,js,php}'
  ],  
  theme: {
    extend: {},
  },
  corePlugins: {
    preflight: true,
    gridColumn: true
  },
  plugins: [],
}

/** Original content 
    './includes/template/*.php',
    './includes/template/** '/*.php',
    './sources/scope-frontend/*.scss',
    './sources/scope-frontend/** '/*.scss'
*/

/** 
Specify safe list if not compile all tailwindcss library : 
safelist: [
    'grid', 'grid-cols-12', 'col-span-3', 'col-span-6', 'col-start-9'
], 
*/

/* Ensure grid column utilities are enabled : gridColumn: true */