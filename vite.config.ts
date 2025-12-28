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
        onSuccess: ({ page }) => {
          console.log(`Prerendered ${page.path} to static html`)
        },
      },
    }),
    viteReact(),
  ],
})

export default config
