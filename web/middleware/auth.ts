import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();

export default defineNuxtRouteMiddleware((to) => {
  if (authStore.isAuthenticated === false) {
    return navigateTo("/login");
  }
});
