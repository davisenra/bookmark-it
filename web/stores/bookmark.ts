import { defineStore } from "pinia";
import { Bookmark, BookmarkResponse } from "@/types/types";

type FetchBookmarksOptions = {
  visitedOnly?: 0 | 1;
  page?: number;
  perPage?: number;
  sortBy?: string;
  sortDirection?: "asc" | "desc";
  tag?: string;
};

export const useBookmarkStore = defineStore("bookmark", () => {
  const bookmarks: Ref<BookmarkResponse | undefined> = ref();

  const getBookmarks = computed(() => bookmarks.value?.data);
  const getUnvisitedBookmarks = computed(
    () => bookmarks.value?.data.filter((bookark) => bookark.visited === false),
  );
  const getMetada = computed(() => bookmarks.value?.meta);

  async function fetchBookmarks({
    page = 1,
    perPage = 30,
    sortBy = "created_at",
    sortDirection = "desc",
  }: FetchBookmarksOptions = {}): Promise<void> {
    const queryParams = new URLSearchParams({
      page: page.toString(),
      per_page: perPage.toString(),
      sort_by: sortBy,
      sort_direction: sortDirection,
    });

    try {
      const res = await useApiFetch(`/v1/bookmarks?${queryParams.toString()}`);
      const data: BookmarkResponse = await res.json();
      bookmarks.value = data;
    } catch (err) {
      console.error(err);
    }
  }

  async function deleteBookmark(id: string): Promise<void> {
    await useApiFetch(`/v1/bookmarks/${id}`, {
      method: "DELETE",
    });
  }

  async function markBookmarkAsVisited(id: string): Promise<void> {
    await useApiFetch(`/v1/bookmarks/${id}/visited`, {
      method: "PATCH",
    });
  }

  return {
    getBookmarks,
    getUnvisitedBookmarks,
    getMetada,
    fetchBookmarks,
    deleteBookmark,
    markBookmarkAsVisited,
  };
});
