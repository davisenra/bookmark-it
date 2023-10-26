<script setup lang="ts">
import { CreateBookmarkPayload, useBookmarkStore } from "@/stores/bookmark";
import { AlertType, pushAlert } from "@/composables/useAlert";

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
    } catch (error: any) {
        pushAlert({
            message: error.message,
            type: AlertType.ERROR,
        });
    }

    isSending.value = false;
}

async function generateTitle() {
    isFetchingTitle.value = true;

    const newTitle = await useTitleGenerator(bookmark.value.url);

    if (newTitle === null) {
        isFetchingTitle.value = false;
        pushAlert({ message: "It was not possible to generate a title", type: AlertType.ERROR });
        return;
    }

    bookmark.value.title = newTitle;
    isFetchingTitle.value = false;
}
</script>

<template>
    <FormKit type="form" :actions="false" @submit="handleBookmarkCreation">
        <FormKit validation="required|length:2,120" v-model="bookmark.title" label="Title" type="text" />
        <div>
            <FormKit
                validation="required|maxlength:255|url"
                v-model="bookmark.url"
                label="URL"
                type="text"
                placeholder="https://"
            />
            <button class="btn btn-sm my-2" type="button" @click="generateTitle">
                <span v-if="!isFetchingTitle">Generate Title</span>
                <span v-else class="loading loading-spinner"></span>
            </button>
        </div>
        <FormKit validation="maxlength:255" v-model="bookmark.description" label="Description" type="text" />
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
    </FormKit>
</template>
