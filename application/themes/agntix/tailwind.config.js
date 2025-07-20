/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
		"./src/scss/**/*.scss",
		"./elements/**/*.php",
		"../../blocks/**/*.php",
		"../../elements/**/*.php",
		"../../single_pages/**/*.php",
		"../../page_templates/**/*.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

