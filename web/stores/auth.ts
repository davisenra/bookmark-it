import { defineStore } from "pinia";

export const useAuthStore = defineStore(
  "auth",
  () => {
    const isAuthenticated = ref(false);

    async function csrfToken(): Promise<void> {
      await useApiFetch(`/sanctum/csrf-cookie`, { method: "GET" });
    }

    async function login(credentials: {
      email: string;
      password: string;
    }): Promise<void> {
      await csrfToken();

      const res = await useApiFetch(`/login`, {
        method: "POST",
        body: JSON.stringify(credentials),
      });

      if (res.status === 204) {
        isAuthenticated.value = true;
        navigateTo("/");
        return;
      }

      if (res.status >= 500) {
        throw Error("Internal server error");
      }

      if (res.status === 422) {
        throw Error("Invalid credentials");
      }
    }

    async function logout(): Promise<void> {
      try {
        await useApiFetch(`/logout`, { method: "POST" });
        isAuthenticated.value = false;
        navigateTo("login");
      } catch (err) {
        console.error(err);
      }
    }

    return {
      isAuthenticated,
      login,
      logout,
    };
  },
  { persist: true },
);
