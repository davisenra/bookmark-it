// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    ssr: false,
    spaLoadingTemplate: false,
    app: {
        head: {
            title: "Bookmark It",
            link: [
                {
                    rel: "preconnect",
                    href: "https://fonts.googleapis.com",
                },
                {
                    rel: "preconnect",
                    href: "https://fonts.gstatic.com",
                },
                {
                    rel: "stylesheet",
                    href: "https://fonts.googleapis.com/css2?family=Inter&display=swap",
                },
            ],
        },
        pageTransition: { name: "page", mode: "out-in" },
    },
    runtimeConfig: {
        public: {
            apiBase: process.env.API_BASE,
            appDomain: process.env.APP_DOMAIN,
        },
    },
    devtools: { enabled: false },
    modules: ["@pinia/nuxt", "@pinia-plugin-persistedstate/nuxt", "@nuxtjs/tailwindcss", "nuxt-icon"],
});
