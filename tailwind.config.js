module.exports = {
  purge: ["./src/**/*.{js,jsx,ts,tsx}"],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      backgroundImage: theme => ({
        "header-image": "url('../images/porthmadogCob.jpg')"
      })
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
