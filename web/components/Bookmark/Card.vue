<script setup lang="ts">
import { useBookmarkStore } from "@/stores/bookmark";
import { Bookmark } from "types/types";

const { bookmark } = defineProps<{ bookmark: Bookmark }>();
const bookmarkStore = useBookmarkStore();

async function handleMarkBookmarkAsVisited(id: string): Promise<void> {
  await bookmarkStore.markBookmarkAsVisited(id);
  await bookmarkStore.fetchBookmarks();
}

async function handleDelete(id: string): Promise<void> {
  await bookmarkStore.deleteBookmark(id);
  await bookmarkStore.fetchBookmarks();
}
</script>

<template>
  <div
    class="flex flex-col rounded border border-t-4 p-4 shadow-md"
    :class="[bookmark.visited ? 'border-t-success' : 'border-t-base']"
  >
    <div class="flex flex-grow justify-between">
      <p class="prose-lg w-3/4 font-bold">
        {{ bookmark.title }}
      </p>
      <div>
        <div
          v-if="bookmark.description"
          class="dropdown dropdown-end dropdown-hover"
        >
          <label tabindex="0" class="btn btn-square btn-ghost btn-sm m-1">
            <Icon name="ph:info" size="24" />
          </label>
          <div
            class="dropdown-content rounded-box z-[1] w-52 bg-base-100 p-3 shadow"
          >
            <p class="prose-sm">{{ bookmark.description }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="my-3 flex flex-wrap gap-2">
      <BookmarkTagBadge v-for="tag in bookmark.tags" :key="tag.id" :tag="tag" />
    </div>
    <div class="flex items-center justify-between">
      <a
        class="btn btn-ghost btn-sm w-max"
        :href="bookmark.url"
        target="_blank"
      >
        <Icon name="ph:link" size="18" />Visit
      </a>
      <div class="flex items-center justify-between space-x-2">
        <ButtonConfirm @confirm="handleMarkBookmarkAsVisited(bookmark.id)" />
        <ButtonDelete @delete="handleDelete(bookmark.id)" />
      </div>
    </div>
  </div>
</template>
