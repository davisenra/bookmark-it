import { defineStore } from "pinia";
import { TagResponse } from "types/types";

export const useTagStore = defineStore("tag", () => {
    async function fetchTags() {
        try {
            const res = await useApiFetch(`/v1/tags`);
            const data: TagResponse = await res?.json();
            return data;
        } catch (err) {
            console.error(err);
        }
    }

    async function createTag(payload: { name: string }): Promise<void> {
        try {
            await useApiFetch(`/v1/tags`, {
                method: "POST",
                body: JSON.stringify(payload),
            });
        } catch (err) {
            console.error(err);
        }
    }

    async function deleteTag(id: number): Promise<void> {
        try {
            await useApiFetch(`/v1/tags/${id}`, {
                method: "DELETE",
            });
        } catch (err) {
            console.error(err);
        }
    }

    return {
        fetchTags,
        createTag,
        deleteTag,
    };
});
