<script setup lang="ts">
import { type Tag } from "@/types/types";
import { useTagStore } from "@/stores/tag";

const tagStore = useTagStore();
const tags = tagStore.getTags();

const availableTags = computed(() => {
    return tags.value?.sort((a, b) => a.name.localeCompare(b.name));
});

const { pickedTagsBag } = defineProps<{ pickedTagsBag: Tag[] }>();

function toggleTagPicked(tag: Tag): void {
    const index = pickedTagsBag.findIndex((t) => t.id === tag.id);

    if (index !== -1) {
        pickedTagsBag.splice(index, 1);
        return;
    }

    pickedTagsBag.push(tag);
}

function isTagPicked(tag: Tag) {
    return pickedTagsBag.some((pickedTag) => pickedTag.id === tag.id);
}
</script>

<template>
    <div class="my-2 flex flex-wrap gap-3">
        <button
            type="button"
            class="btn btn-sm rounded-full"
            :class="{
                'bg-accent text-accent-content hover:bg-accent-focus': isTagPicked(tag),
            }"
            v-for="tag in availableTags?.sort()"
            :key="tag.id"
            @click="toggleTagPicked(tag)"
        >
            {{ tag.name }}
        </button>
        <p v-if="availableTags === undefined" class="prose-sm">
            {{ "Looks like you have no tags :(" }}
        </p>
    </div>
</template>
