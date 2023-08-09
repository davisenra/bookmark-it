import { defineStore } from "pinia";
import { Tag, TagResponse } from "types/types";

export const useTagStore = defineStore("tag", () => {
    const tags: Ref<TagResponse | undefined> = ref();

    const getTags = computed(() => tags.value?.data);
    const getMetada = computed(() => tags.value?.meta);

    const sortAscending = ref(true);

    async function fetchTags(): Promise<void> {
        try {
            const res = await useApiFetch(`/v1/tags`);
            const data: TagResponse = await res.json();
            tags.value = data;
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

    function sortTagsAlphabetically(): void {
        tags.value?.data.sort((a, b) => {
            const compareResult = a.name.localeCompare(b.name);
            return sortAscending.value ? compareResult : -compareResult;
        });

        sortAscending.value = !sortAscending.value;
    }

    return {
        getTags,
        getMetada,
        fetchTags,
        sortTagsAlphabetically,
        createTag,
        deleteTag,
    };
});
