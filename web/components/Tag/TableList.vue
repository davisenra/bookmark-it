<script setup lang="ts">
import { useTagStore } from "@/stores/tag";

const tagStore = useTagStore();
await tagStore.fetchTags();

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
          <th
            @click="tagStore.sortTagsAlphabetically"
            class="cursor-pointer hover:underline"
          >
            Name
          </th>
          <th class="w-12">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="tag in tagStore.getTags" :key="tag.id" class="hover">
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
