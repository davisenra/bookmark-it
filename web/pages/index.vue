<script setup lang="ts">
import { useBookmarkStore } from "@/stores/bookmark";
import { useTagStore } from "@/stores/tag";

definePageMeta({
    middleware: "auth",
});

const bookmarkStore = useBookmarkStore();
const tagStore = useTagStore();

await Promise.all([bookmarkStore.fetchBookmarks(), tagStore.fetchTags()]);
</script>

<template>
    <div class="flex flex-col space-y-6">
        <div>
            <h1 class="prose-2xl font-bold">Stats</h1>
            <div class="divider my-2"></div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Bookmarks</div>
                    <div class="stat-value text-primary">
                        {{ bookmarkStore.getMetada?.total }}
                    </div>
                </div>
                <div class="stat">
                    <div class="stat-title">Tags</div>
                    <div class="stat-value text-primary">
                        {{ tagStore.getMetada?.total }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
