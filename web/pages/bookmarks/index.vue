<script setup lang="ts">
import { FetchBookmarksOptions, useBookmarkStore } from "@/stores/bookmark";
import { BookmarkCollectionResponse } from "@/types/types";
import { useTagStore } from "@/stores/tag";
import { debounce } from "debounce";

definePageMeta({
    middleware: "auth",
});

const bookmarkStore = useBookmarkStore();
const bookmarks = ref<BookmarkCollectionResponse | null>(null);

const tagStore = useTagStore();
const tags = tagStore.getTags();

const filters = ref({
    currentPage: 1,
    filterByTag: null,
    filterByTitle: "",
});

function resetFilters(): void {
    filters.value.filterByTitle = "";
    filters.value.filterByTag = null;
}

const handleUpdateTable = debounce(async function () {
    const options: FetchBookmarksOptions = {
        page: filters.value.currentPage,
        tag: filters.value.filterByTag || undefined,
        searchBy: filters.value.filterByTitle || undefined,
    };

    const bookmarksResponse = await bookmarkStore.fetchBookmarks(options);

    bookmarks.value = bookmarksResponse ?? null;
}, 500);

onMounted(async () => {
    bookmarks.value = (await bookmarkStore.fetchBookmarks()) || null;
});
</script>

<template>
    <div class="flex flex-col space-y-2 rounded-md bg-white p-6 shadow-md">
        <h1 class="prose-2xl font-bold">Bookmarks</h1>
        <div class="divider my-2"></div>
        <div class="py-3">
            <p class="prose mb-2 font-bold">Filters</p>
            <div class="flex flex-wrap gap-3">
                <input
                    @input="
                        filters.filterByTitle.length > 2 || filters.filterByTitle.length === 0
                            ? handleUpdateTable()
                            : null
                    "
                    v-model="filters.filterByTitle"
                    class="input input-bordered input-sm"
                    placeholder="Seach by title"
                />
                <select
                    @change="
                        filters.currentPage = 1;
                        handleUpdateTable();
                    "
                    v-model="filters.filterByTag"
                    class="select select-bordered select-sm"
                >
                    <option :value="null" selected>Tag</option>
                    <option :value="tag.name" v-for="tag in tags">
                        {{ tag.name }}
                    </option>
                </select>
                <button
                    class="btn btn-sm"
                    @click="
                        resetFilters();
                        handleUpdateTable();
                    "
                >
                    <Icon name="ci:undo" />
                </button>
            </div>
        </div>
        <div class="w-full">
            <BookmarkTable :bookmarks="bookmarks?.data ?? []" @update="handleUpdateTable" />
        </div>
        <div class="join my-3 w-full justify-end">
            <button
                class="btn join-item btn-sm"
                :disabled="filters.currentPage === 1"
                @click="
                    filters.currentPage -= 1;
                    handleUpdateTable();
                "
            >
                <Icon name="ph:caret-left-bold" />
            </button>
            <button class="btn join-item btn-sm">Page {{ filters.currentPage }}</button>
            <button
                class="btn join-item btn-sm"
                :disabled="filters.currentPage === bookmarks?.meta.last_page"
                @click="
                    filters.currentPage += 1;
                    handleUpdateTable();
                "
            >
                <Icon name="ph:caret-right-bold" />
            </button>
        </div>
    </div>
</template>
