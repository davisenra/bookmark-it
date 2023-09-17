import { defineStore } from "pinia";
import { BookmarkResponse, Tag } from "@/types/types";

export type FetchBookmarksOptions = {
    visitedOnly?: 0 | 1;
    page?: number;
    perPage?: number;
    searchBy?: string;
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
    async function fetchBookmarks({
        page = 1,
        perPage = 30,
        sortBy = "created_at",
        sortDirection = "desc",
        tag = undefined,
        searchBy = undefined,
    }: FetchBookmarksOptions = {}) {
        const queryParams = new URLSearchParams({
            page: page.toString(),
            per_page: perPage.toString(),
            sort_by: sortBy,
            sort_direction: sortDirection,
        });

        if (tag !== undefined) {
            queryParams.append("tag", tag);
        }

        if (searchBy !== undefined) {
            queryParams.append("search_by", searchBy);
        }

        try {
            const res = await useApiFetch(`/v1/bookmarks?${queryParams.toString()}`);
            return (await res?.json()) as BookmarkResponse;
        } catch (err) {
            console.error(err);
        }
    }

    async function createBookmark(payload: CreateBookmarkPayload) {
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

    async function deleteBookmark(id: string) {
        await useApiFetch(`/v1/bookmarks/${id}`, {
            method: "DELETE",
        });
    }

    async function markBookmarkAsVisited(id: string) {
        await useApiFetch(`/v1/bookmarks/${id}/visited`, {
            method: "PATCH",
        });
    }

    return {
        fetchBookmarks,
        createBookmark,
        deleteBookmark,
        markBookmarkAsVisited,
    };
});
