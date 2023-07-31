<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";
const authStore = useAuthStore();

async function handleLogout(): Promise<void> {
  await authStore.logout();
}
</script>

<template>
  <div class="drawer">
    <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
      <slot />
    </div>
    <div class="drawer-side">
      <label for="sidebar-drawer" class="drawer-overlay"></label>
      <ul class="menu h-full w-80 bg-base-200 p-4 text-base-content">
        <li>
          <NuxtLink to="/" class="text-lg font-semibold">
            <Icon name="ph:house-bold" /> Dashboard
          </NuxtLink>
        </li>
        <li>
          <NuxtLink to="/tags" class="text-lg font-semibold">
            <Icon name="ph:bookmark-bold" /> Bookmarks
          </NuxtLink>
        </li>
        <li>
          <NuxtLink to="/tags" class="text-lg font-semibold">
            <Icon name="ph:tag-bold" /> Tags
          </NuxtLink>
        </li>
        <div class="divider"></div>
        <li>
          <button
            @click="handleLogout"
            type="button"
            class="text-lg font-semibold"
          >
            <Icon name="ph:sign-out-bold" /> Logout
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>
