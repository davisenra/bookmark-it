<script setup lang="ts">
import { useBookmarkStore } from "@/stores/bookmark";

definePageMeta({
  middleware: "auth",
});

const currentPage = ref(1);

const bookmarkStore = useBookmarkStore();

await bookmarkStore.fetchBookmarks({
  page: currentPage.value,
});
</script>

<template>
  <div class="container mx-auto my-6 flex flex-col space-y-6 px-3">
    <div>
      <h1 class="prose-2xl font-bold">Bookmarks</h1>
      <div class="divider my-2"></div>
      <div class="join my-2 w-full justify-end">
        <button class="btn join-item">
          <Icon name="ph:caret-left-bold" />
        </button>
        <button class="btn join-item">Page 22</button>
        <button class="btn join-item">
          <Icon name="ph:caret-right-bold" />
        </button>
      </div>
      <BookmarkTableList :bookmarks="bookmarkStore.getBookmarks ?? []" />
    </div>
  </div>
</template>