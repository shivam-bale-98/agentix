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
    extend: {
      screens: {
				xxl: "1600px",
				xl: "1279px",
				xmd: "991px",
        sm: "640px",
        md: "768px",
        lg: "1024px",
			},
    },
  },
  plugins: [],
}

