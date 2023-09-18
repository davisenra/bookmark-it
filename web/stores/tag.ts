import { defineStore } from "pinia";
import { Tag, TagResponse } from "types/types";
import { Ref } from "vue";

export const useTagStore = defineStore("tag", () => {
    const tags: Ref<Tag[]> = ref([]);
    const tagsHaveBeenFetched = ref(false);

    function getTags() {
        if (tagsHaveBeenFetched.value === false) {
            fetchTags();
        }

        return tags;
    }

    async function fetchTags() {
        try {
            const res = await useApiFetch(`/v1/tags`);
            const { data }: TagResponse = await res?.json();
            tags.value = data;
            tagsHaveBeenFetched.value = true;
        } catch (err) {
            console.error(err);
        }
    }

    async function createTag(payload: { name: string }) {
        try {
            await useApiFetch(`/v1/tags`, {
                method: "POST",
                body: JSON.stringify(payload),
            });
        } catch (err) {
            console.error(err);
        }
    }

    async function deleteTag(id: number) {
        try {
            await useApiFetch(`/v1/tags/${id}`, {
                method: "DELETE",
            });
        } catch (err) {
            console.error(err);
        }
    }

    return {
        getTags,
        fetchTags,
        createTag,
        deleteTag,
    };
});
