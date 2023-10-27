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

    if (bookmark.value.url === "") {
        isFetchingTitle.value = false;
        pushAlert({ message: "URL is required", type: AlertType.ERROR });
        return;
    }

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
        <FormKit
            validation="required|maxlength:255|url"
            v-model="bookmark.url"
            label="URL"
            type="text"
            placeholder="https://"
        />
        <FormKit validation="maxlength:255" v-model="bookmark.description" label="Description" type="text" />
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Tags</span>
            </label>
            <TagPicker :picked-tags-bag="bookmark.tags" />
        </div>
        <div class="my-3 flex space-x-2">
            <button type="submit" class="btn btn-primary">
                <Icon v-if="!isSending" name="ph:floppy-disk-bold" size="20" />
                <span v-else class="loading loading-spinner"></span>
                Save
            </button>
            <button class="btn flex items-center" type="button" @click="generateTitle">
                <span v-if="!isFetchingTitle">
                    Generate Title
                    <Icon name="ph:lightbulb-bold" size="16" />
                </span>
                <span v-else class="loading loading-spinner"></span>
            </button>
        </div>
    </FormKit>
</template>
