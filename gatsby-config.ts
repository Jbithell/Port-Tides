import type { GatsbyConfig } from "gatsby";

const config: GatsbyConfig = {
  siteMetadata: {
    title: "Porthmadog Tide Times",
    titleTemplate: "%s | Porthmadog Tide Times",
    description:
      "Free tidal predictions for the seaside town of Porthmadog and its beautiful estuary. The best place to get tide times for Porthmadog, Borth-y-gest, Morfa Bychan and Black rock sands",
    author: "jbithell",
    siteUrl: "https://port-tides.com",
  },
  // More easily incorporate content into your pages through automatic TypeScript type generation and better GraphQL IntelliSense.
  // If you use VSCode you can also use the GraphQL plugin
  // Learn more at: https://gatsby.dev/graphql-typegen
  graphqlTypegen: true,
  plugins: [
    "gatsby-plugin-postcss",
    "gatsby-plugin-sitemap",
    {
      resolve: "gatsby-source-filesystem",
      options: {
        name: "pages",
        path: "./src/pages/",
      },
      __key: "pages",
    },
    {
      resolve: "gatsby-source-build-date",
      options: {
        locales: "en-GB",
        options: {
          year: "numeric",
        },
      },
    },
  ],
};

export default config;
