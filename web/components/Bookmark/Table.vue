<script setup lang="ts">
import { Bookmark } from "@/types/types";
import { useBookmarkStore } from "@/stores/bookmark";

const bookmarkStore = useBookmarkStore();

defineProps<{
    bookmarks: Bookmark[];
}>();

const emit = defineEmits(["update"]);

async function handleMarkAsVisited(bookmark: Bookmark) {
    await bookmarkStore.markBookmarkAsVisited(bookmark.id);
    emit("update");
}

async function handleDeleteBookmark(bookmark: Bookmark) {
    await bookmarkStore.deleteBookmark(bookmark.id);
    emit("update");
}
</script>

<template>
    <div class="mb-3 overflow-x-auto overflow-y-clip">
        <table class="table table-xs">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Visited at</th>
                    <th>Created at</th>
                    <th class="w-36">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="bookmark in bookmarks"
                    :key="bookmark.id"
                    class="hover border-l-4"
                    :class="[bookmark.visited ? 'border-l-success' : 'border-l-warning']"
                >
                    <td class="w-4/6">
                        <div class="prose-sm flex flex-col gap-2">
                            <a :href="bookmark.url" class="link-hover" target="_blank">
                                {{ bookmark.title.length > 50 ? bookmark.title.slice(0, 50) + "..." : bookmark.title }}
                            </a>
                            <div class="flex space-x-1">
                                <BookmarkTagBadge v-for="tag in bookmark.tags" :key="tag.id" :tag="tag" />
                            </div>
                        </div>
                    </td>
                    <td class="w-6">
                        {{ bookmark.visited_at ? new Date(bookmark.visited_at).toLocaleDateString() : "" }}
                    </td>
                    <td class="w-6">
                        {{ new Date(bookmark.created_at).toLocaleDateString() }}
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            <router-link :to="'/bookmarks/' + bookmark.id" class="btn btn-sm">
                                <Icon name="ph:note-pencil" size="16" />
                            </router-link>
                            <ButtonConfirm @confirm="handleMarkAsVisited(bookmark)" />
                            <ButtonDelete @delete="handleDeleteBookmark(bookmark)" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
