module.exports = {
  siteMetadata: {
    title: "Porthmadog Tide Times",
  },
  plugins: [
    "gatsby-plugin-postcss",
    "gatsby-plugin-image",
    "gatsby-plugin-react-helmet",
    "gatsby-plugin-sharp",
    "gatsby-transformer-sharp",
    {
      resolve: "gatsby-source-filesystem",
      options: {
        name: "images",
        path: "./src/images/",
      },
      __key: "images",
    },
    {
      resolve: "gatsby-plugin-i18n",
      options: {
        langKeyDefault: "en", //cy or cy-GB
        langKeyForNull: "en",
        prefixDefault: false,
        useLangKeyLayout: false,
      },
    },
    {
      resolve: "gatsby-plugin-manifest",
      options: {
        name: "Porthmadog Tide Times",
        short_name: "Port-Tides",
        description: "Free tidal predictions using data from the UK Hydrographic Office for the town of Porthmadog, and associated villages",
        start_url: "/",
        background_color: "#f7f0eb",
        theme_color: "#93c5fd",
        display: "standalone",
        icon: "src/images/icon.png",
        icon_options: {
          purpose: "any maskable",
        },
        cache_busting_mode: "none",
      },
    },
    {
      resolve: "gatsby-plugin-offline",
      options: {
        globPatterns: ["**/images/*"],
        precachePages: ["**/tide-tables/*"],
      },
    },
    {
      resolve: "gatsby-source-build-date",
      options: {
        locales: "en-GB",
        options: {
          year: "long",
        },
      },
    },
  ],
};
