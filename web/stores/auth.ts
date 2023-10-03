import { defineStore } from "pinia";

export const useAuthStore = defineStore(
    "auth",
    () => {
        const isAuthenticated = ref(false);

        async function csrfToken() {
            await useApiFetch(`/sanctum/csrf-cookie`, { method: "GET" });
        }

        async function login(credentials: { email: string; password: string; remember?: boolean }) {
            await csrfToken();

            credentials.remember = true;

            const res = await useApiFetch(`/login`, {
                method: "POST",
                body: JSON.stringify(credentials),
            });

            if (res?.status === 204 || res?.redirected) {
                isAuthenticated.value = true;
                navigateTo("/");
                return;
            }

            if (res?.status === 422) {
                throw Error("Invalid credentials");
            }

            throw Error("Internal server error");
        }

        async function logout() {
            await useApiFetch(`/logout`, { method: "POST" }).catch((err) => console.log(err));
            isAuthenticated.value = false;
            navigateTo("login");
        }

        async function register(credentials: {
            name: string;
            email: string;
            password: string;
            password_confirmation: string;
        }) {
            await csrfToken();

            const res = await useApiFetch(`/register`, {
                method: "POST",
                body: JSON.stringify(credentials),
            });

            if (res?.status === 204) {
                isAuthenticated.value = true;
                navigateTo("/");
                return;
            }

            if (res?.status === 422) {
                throw Error("Invalid credentials");
            }

            throw Error("Internal server error");
        }

        return {
            isAuthenticated,
            login,
            logout,
            register,
        };
    },
    {
        persist: {
            storage: localStorage,
        },
    },
);
