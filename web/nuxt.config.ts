// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  app: {
    pageTransition: { name: "page", mode: "out-in" },
  },
  ssr: false,
  devtools: { enabled: false },
  modules: ["@pinia/nuxt", "@nuxtjs/tailwindcss", "nuxt-icon"],
});
