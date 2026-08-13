import tailwindcss from '@tailwindcss/vite'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2026-08-12',
  ssr: true,
  devtools: { enabled: true },

  modules: ['@pinia/nuxt', '@nuxt/image', '@nuxt/fonts'],

  css: ['~/assets/css/main.css'],

  // Tailwind v4 is configured in CSS (app/assets/css/main.css), not a config file.
  vite: {
    plugins: [tailwindcss()],
  },

  typescript: {
    strict: true,
    // Inline checking is off because vite-plugin-checker splits the project
    // path on whitespace, and this directory name contains spaces — it looks
    // for `.../texmart/tsconfig.json`, `.../frontend/laravel/tsconfig.json`
    // and so on. `pnpm typecheck` runs vue-tsc directly and is unaffected, so
    // that is the gate. Rename the folder without spaces to turn this back on.
    typeCheck: false,
  },

  // Pinia stores and the repository layer are auto-imported like composables,
  // so pages call `listProducts()` without an import line and never reach for
  // `$fetch` themselves.
  imports: {
    dirs: ['stores', 'repositories'],
  },

  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000/api/v1',
      useMocks: true,
    },
  },

  fonts: {
    families: [
      // Variable so the 650 weight the design calls for renders truthfully
      // instead of snapping to 600 or 700.
      { name: 'Inter', provider: 'google', weights: ['400 700'] },
      { name: 'JetBrains Mono', provider: 'google', weights: [500] },
    ],
    defaults: {
      preload: true,
    },
  },

  app: {
    head: {
      htmlAttrs: { lang: 'uz' },
      link: [{ rel: 'icon', type: 'image/svg+xml', href: '/favicon.svg' }],
      meta: [{ name: 'theme-color', content: '#1E90FF' }],
    },
  },
})
