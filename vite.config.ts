import { cloudflare } from '@cloudflare/vite-plugin'
import { devtools } from '@tanstack/devtools-vite'
import { tanstackStart } from '@tanstack/react-start/plugin/vite'
import viteReact from '@vitejs/plugin-react'
import { defineConfig } from 'vite'
import viteTsConfigPaths from 'vite-tsconfig-paths'

const config = defineConfig({
  plugins: [
    devtools(),
    cloudflare({ viteEnvironment: { name: 'ssr' } }),
    viteTsConfigPaths({
      projects: ['./tsconfig.json'],
    }),
    tanstackStart({
      prerender: {
        enabled: true,
        crawlLinks: true, // Render dynamic routes like the tide table pages because they are linked to from pages
        autoStaticPathsDiscovery: true,
        concurrency: 14, // Cloudflare workers build runs out of memory quite easily
        filter: ({ path }) => path !== "/" && !path.endsWith(".pdf") // Do not prerender the home page or PDFs, as these get copied from the public directory
      },
      sitemap: {
        enabled: true,
        host: 'https://port-tides.com',
      },
    }),
    viteReact(),
  ],
})

export default config
