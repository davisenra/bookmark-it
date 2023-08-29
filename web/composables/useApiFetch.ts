import { useAuthStore } from "~/stores/auth";

export async function useApiFetch(path: string, options?: RequestInit) {
    const authStore = useAuthStore();

    const token = useCookie("XSRF-TOKEN");

    const headers = {
        Accept: "application/json",
        "Content-Type": "application/json",
        Referer: useRuntimeConfig().public.appDomain,
        "X-XSRF-TOKEN": token.value as string,
    };

    const res = await fetch(`${useRuntimeConfig().public.apiBase + path}`, {
        credentials: "include",
        ...options,
        headers: {
            ...headers,
            ...options?.headers,
        },
    });

    if (res.status === 401) {
        authStore.isAuthenticated = false;
        navigateTo("login");
        return;
    }

    return res;
}
