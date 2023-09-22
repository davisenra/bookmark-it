<script setup lang="ts">
import { Bookmark } from "@/types/types";
import { useBookmarkStore } from "@/stores/bookmark";

const route = useRoute();
const bookmarkId = route.params.id as string;
const bookmarkStore = useBookmarkStore();
const bookmark: Ref<Bookmark | null> = ref(null);
const isSending = ref(false);

async function handleBookmarkEditAction() {
    if (!bookmark.value) return;
    isSending.value = true;
    try {
        await bookmarkStore.updateBookmark(bookmark.value);
    } catch (err) {
        console.log(err);
        return;
    }

    bookmark.value = await bookmarkStore.fetchBookmarkById(bookmarkId);
    isSending.value = false;
}

onMounted(async () => {
    try {
        bookmark.value = await bookmarkStore.fetchBookmarkById(bookmarkId);
    } catch (err) {
        await navigateTo("/bookmarks");
    }
});
</script>

<template>
    <div class="flex flex-col space-y-2 rounded-md bg-white p-6 shadow-md" v-if="bookmark">
        <div class="flex items-center space-x-3">
            <nuxt-link to="/bookmarks" class="btn btn-square btn-sm">
                <Icon name="ic:outline-arrow-back" size="16" />
            </nuxt-link>
            <h1 class="prose-2xl font-bold">Edit</h1>
        </div>
        <div class="divider my-2"></div>
        <div class="space-y-3 py-3">
            <form class="max-w-xl" @submit.prevent="handleBookmarkEditAction()">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Title</span>
                    </label>
                    <input v-model="bookmark.title" type="text" required class="input input-bordered" />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">URL</span>
                    </label>
                    <input v-model="bookmark.url" disabled type="text" class="input input-bordered" />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Description </span>
                    </label>
                    <textarea v-model="bookmark.description" class="textarea textarea-bordered"></textarea>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Tags</span>
                    </label>
                    <TagPicker :picked-tags-bag="bookmark.tags" />
                </div>
                <button type="submit" class="btn btn-primary my-3">
                    <Icon v-if="!isSending" name="ph:floppy-disk-bold" size="20" />
                    <span v-else class="loading loading-spinner"></span>
                    Save
                </button>
            </form>
        </div>
    </div>
</template>
