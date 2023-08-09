<script setup lang="ts">
import { useTagStore } from "@/stores/tag";

const tagStore = useTagStore();
const tagName = ref("");
const isCreating = ref(false);

async function handleTagCreation(): Promise<void> {
    isCreating.value = true;

    try {
        await tagStore.createTag({ name: tagName.value });
        await tagStore.fetchTags();
        tagName.value = "";
    } catch (err) {
        console.error(err);
    }

    isCreating.value = false;
}
</script>

<template>
    <form class="w-full max-w-xl" @submit.prevent="handleTagCreation">
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Tag</span>
            </label>
            <input v-model="tagName" minlength="3" type="text" placeholder="Tag" class="input input-bordered" />
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary" :disabled="isCreating">
                <span v-if="!isCreating">
                    <Icon name="ph:floppy-disk-bold" size="20" />
                </span>
                <span v-else class="loading loading-spinner"></span>
                Save
            </button>
        </div>
    </form>
</template>
