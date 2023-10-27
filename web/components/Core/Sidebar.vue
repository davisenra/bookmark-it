<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";
const authStore = useAuthStore();

async function handleLogout() {
    await authStore.logout();
}
</script>

<template>
    <div class="drawer">
        <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content bg-base-200 min-w-0">
            <slot />
        </div>
        <div class="drawer-side">
            <label for="sidebar-drawer" class="drawer-overlay"></label>
            <ul class="menu text-base-content h-full w-80 space-y-2 border bg-white p-4">
                <li>
                    <NuxtLink to="/" class="text-lg font-semibold" @click="console.log('debug')">
                        <Icon name="ph:house-bold" />
                        Dashboard
                    </NuxtLink>
                </li>
                <li>
                    <NuxtLink to="/bookmarks" class="text-lg font-semibold">
                        <Icon name="ph:bookmark-bold" />
                        Bookmarks
                    </NuxtLink>
                </li>
                <li>
                    <NuxtLink to="/tags" class="text-lg font-semibold">
                        <Icon name="ph:tag-bold" />
                        Tags
                    </NuxtLink>
                </li>
                <div class="divider"></div>
                <li>
                    <button @click="handleLogout" type="button" class="text-lg font-semibold">
                        <Icon name="ph:sign-out-bold" />
                        Logout
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>
