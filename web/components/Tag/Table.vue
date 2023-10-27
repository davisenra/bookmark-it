<script setup lang="ts">
import { useTagStore } from "@/stores/tag";
import { type Tag } from "~/types/types";

const tagStore = useTagStore();
const tags = tagStore.getTags();

function sortTagsAlphabetically() {
    tags?.value?.sort((a: Tag, b: Tag) => a.name.localeCompare(b.name));
}

async function handleTagDelete(id: number): Promise<void> {
    await tagStore.deleteTag(id);
    await tagStore.fetchTags();
}
</script>

<template>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-24"></th>
                    <th @click="sortTagsAlphabetically()" class="cursor-pointer hover:underline">Name</th>
                    <th class="w-12">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tag in tags" :key="tag.id" v-if="tags" class="hover">
                    <th>{{ tag.id }}</th>
                    <td>{{ tag.name }}</td>
                    <td>
                        <ButtonDelete @delete="handleTagDelete(tag.id)" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
