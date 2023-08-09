<script setup lang="ts">
import { useBookmarkStore } from "@/stores/bookmark";
import { Bookmark } from "@/types/types";
import { useTagStore } from "@/stores/tag";

definePageMeta({
  middleware: "auth",
});

onMounted(async () => {
  await Promise.all([
    bookmarkStore.fetchBookmarks({ page: currentPage.value }),
    tagStore.fetchTags(),
  ]);

  bookmarks.value = bookmarkStore.bookmarks?.data ?? [];
});

const currentPage = ref(1);
const filterByName = ref("");
const filterByTag = ref(null);
const showUnvisitedOnly = ref(false);

const bookmarkStore = useBookmarkStore();
const tagStore = useTagStore();
const bookmarks = ref<Bookmark[]>([]);

const filteredBookmarks = computed(() => {
  return bookmarks.value.filter((bookmark) => {
    const titleMatches = bookmark.title
      .toLowerCase()
      .includes(filterByName.value.toLowerCase());

    if (showUnvisitedOnly.value && bookmark.visited) {
      return false;
    }

    if (
      filterByTag.value &&
      !bookmark.tags.some((tag) => tag.name === filterByTag.value)
    ) {
      return false;
    }

    return titleMatches;
  });
});

async function handleUpdateTable(): Promise<void> {
  await bookmarkStore.fetchBookmarks({ page: currentPage.value });
  bookmarks.value = bookmarkStore.bookmarks?.data as Bookmark[];
}

function resetFilters(): void {
  filterByName.value = "";
  filterByTag.value = null;
  showUnvisitedOnly.value = false;
}
</script>

<template>
  <div class="flex flex-col space-y-2">
    <h1 class="prose-2xl font-bold">Bookmarks</h1>
    <div class="divider my-2"></div>
    <div class="py-3">
      <p class="prose mb-2 font-bold">Filters</p>
      <div class="flex flex-wrap gap-3">
        <div>
          <input
            v-model="filterByName"
            class="input input-bordered input-sm"
            placeholder="Search"
          />
        </div>
        <select v-model="filterByTag" class="select select-bordered select-sm">
          <option :value="null" selected>Tag</option>
          <option :value="tag.name" v-for="tag in tagStore.getTags">
            {{ tag.name }}
          </option>
        </select>
        <button
          class="btn btn-sm"
          @click="showUnvisitedOnly = !showUnvisitedOnly"
        >
          {{ showUnvisitedOnly ? "Show all" : "Unvisited only" }}
        </button>
        <button class="btn btn-sm" @click="resetFilters">
          <Icon name="ci:undo" />
        </button>
      </div>
    </div>
    <div class="w-full">
      <BookmarkTableList
        :bookmarks="filteredBookmarks ?? []"
        @update="handleUpdateTable()"
      />
    </div>
    <div class="join my-3 w-full justify-end">
      <button
        class="btn join-item"
        :disabled="currentPage === 1"
        @click="
          currentPage -= 1;
          handleUpdateTable();
        "
      >
        <Icon name="ph:caret-left-bold" />
      </button>
      <button class="btn join-item">Page {{ currentPage }}</button>
      <button
        class="btn join-item"
        :disabled="currentPage === bookmarkStore.getMetada?.last_page"
        @click="
          currentPage += 1;
          handleUpdateTable();
        "
      >
        <Icon name="ph:caret-right-bold" />
      </button>
    </div>
  </div>
</template>
