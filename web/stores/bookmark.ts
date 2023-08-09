import { defineStore } from "pinia";
import { Tag, BookmarkResponse } from "@/types/types";

export type FetchBookmarksOptions = {
    visitedOnly?: 0 | 1;
    page?: number;
    perPage?: number;
    sortBy?: string;
    sortDirection?: "asc" | "desc";
    tag?: string;
};

export type CreateBookmarkPayload = {
    title: string;
    url: string;
    description: string | undefined;
    tags: Tag[];
};

export const useBookmarkStore = defineStore("bookmark", () => {
    const bookmarks: Ref<BookmarkResponse | undefined> = ref();

    const getBookmarks = computed(() => bookmarks.value?.data);
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

    async function createBookmark(payload: CreateBookmarkPayload): Promise<void> {
        const tagsToApi = payload.tags.map((tag) => {
            return {
                id: tag.id,
            };
        });

        try {
            await useApiFetch(`/v1/bookmarks`, {
                method: "POST",
                body: JSON.stringify({
                    ...payload,
                    ...(payload.description === "" && { description: undefined }),
                    tags: tagsToApi,
                }),
            });
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
        bookmarks,
        getBookmarks,
        getMetada,
        fetchBookmarks,
        createBookmark,
        deleteBookmark,
        markBookmarkAsVisited,
    };
});
