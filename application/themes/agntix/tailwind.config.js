/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    // "../../**/*.php"
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

