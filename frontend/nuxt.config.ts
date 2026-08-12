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
    typeCheck: true,
  },

  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000/api/v1',
      useMocks: true,
    },
  },

  // Pinia's default store directory differs under Nuxt 4's app/ srcDir.
  pinia: {
    storesDirs: ['./app/stores/**'],
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
