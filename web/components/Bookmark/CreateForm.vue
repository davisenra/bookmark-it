<script setup lang="ts">
import { CreateBookmarkPayload, useBookmarkStore } from "@/stores/bookmark";

const bookmarkStore = useBookmarkStore();

const bookmark = ref<CreateBookmarkPayload>({
    title: "",
    url: "",
    description: "",
    tags: [],
});

const isSending = ref(false);
const isFetchingTitle = ref(false);

async function handleBookmarkCreation(): Promise<void> {
    isSending.value = true;

    try {
        await bookmarkStore.createBookmark(bookmark.value);
        navigateTo("/bookmarks");
    } catch (e) {
        console.error(e);
    }

    isSending.value = false;
}

async function generateTitle() {
    isFetchingTitle.value = true;

    const newTitle = await useTitleGenerator(bookmark.value.url);

    if (newTitle === null) {
        isFetchingTitle.value = false;
        return;
    }

    bookmark.value.title = newTitle;
    isFetchingTitle.value = false;
}
</script>

<template>
    <form @submit.prevent="handleBookmarkCreation" class="max-w-xl">
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Title</span>
            </label>
            <input v-model="bookmark.title" type="text" placeholder="Title" class="input input-bordered" />
        </div>
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">URL</span>
            </label>
            <div>
                <input
                    v-model="bookmark.url"
                    type="text"
                    placeholder="https://"
                    class="input input-bordered w-full pr-12"
                />
                <button class="btn btn-circle btn-ghost btn-sm fixed -ml-10 mt-2" type="button" @click="generateTitle">
                    <Icon v-if="!isFetchingTitle" name="ph:lightbulb" size="18" />
                    <span v-else class="loading loading-spinner"></span>
                </button>
            </div>
        </div>
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Description </span>
            </label>
            <textarea
                v-model="bookmark.description"
                class="textarea textarea-bordered h-24"
                placeholder="Description"
            ></textarea>
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
</template>
