<script setup lang="ts">
import { Bookmark } from "types/types";

definePageMeta({
  middleware: "auth",
});

const bookmarks: Bookmark[] = [
  {
    id: "06824b38-4263-46ab-a2e2-0ce3720e00b6",
    title: "American Prometheus",
    url: "https://en.wikipedia.org/wiki/American_Prometheus",
    description:
      "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
    visited: false,
    visited_at: null,
    created_at: "2023-07-26T21:50:43.000000Z",
    updated_at: "2023-07-26T21:50:43.000000Z",
    tags: [
      {
        id: 99,
        name: "Movies",
      },
    ],
  },
  {
    id: "9b075083-ed8b-42b7-8cb2-29652daa0765",
    title: "Threads (1984 film) - Wikipedia",
    url: "https://en.wikipedia.org/wiki/Threads_(1984_film)",
    description: null,
    visited: true,
    visited_at: null,
    created_at: "2023-07-26T21:50:43.000000Z",
    updated_at: "2023-07-26T21:50:43.000000Z",
    tags: [
      {
        id: 9,
        name: "History",
      },
      {
        id: 15,
        name: "Atomic Bomb",
      },
    ],
  },
];
</script>

<template>
  <div class="container mx-auto mt-6 flex flex-col space-y-6 px-3">
    <div>
      <h1 class="prose-2xl font-bold">Stats</h1>
      <div class="divider my-2"></div>
      <div class="stats shadow">
        <div class="stat">
          <div class="stat-title">Unread</div>
          <div class="stat-value text-primary">32</div>
        </div>
        <div class="stat">
          <div class="stat-title">Bookmarks</div>
          <div class="stat-value text-primary">245</div>
        </div>
        <div class="stat">
          <div class="stat-title">Tags</div>
          <div class="stat-value text-primary">8</div>
        </div>
      </div>
    </div>
    <div>
      <h1 class="prose-2xl font-bold">Recent bookmarks</h1>
      <div class="divider my-2"></div>
      <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-3">
        <BookmarkCard
          v-for="bookmark in bookmarks"
          :key="bookmark.id"
          :bookmark="bookmark"
        />
      </div>
    </div>
  </div>
</template>
