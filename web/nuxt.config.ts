// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    ssr: false,
    spaLoadingTemplate: false,
    app: {
        head: {
            title: "Bookmark It",
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
    modules: ["@pinia/nuxt", "@pinia-plugin-persistedstate/nuxt", "@nuxtjs/tailwindcss", "nuxt-icon", "@formkit/nuxt"],
    tailwindcss: {
        config: {
            content: ["./formkit.theme.js"],
            theme: {
                extend: {},
            },
            plugins: [require("@formkit/themes/tailwindcss"), require("@tailwindcss/typography"), require("daisyui")],
            daisyui: {
                themes: ["light"],
            },
        },
    },
    formkit: {
        configFile: "formkit.config.js",
    },
});
