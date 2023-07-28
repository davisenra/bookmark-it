<script setup lang="ts">
type Tag = {
  id: number;
  name: string;
};

const availableTags: Ref<Tag[]> = ref([
  { id: 1, name: "PHP" },
  { id: 2, name: "Tech" },
  { id: 3, name: "History" },
  { id: 4, name: "Shopping" },
  { id: 5, name: "Gaming" },
  { id: 6, name: "Javascript" },
  { id: 7, name: "Geography" },
  { id: 8, name: "Books" },
  { id: 9, name: "Youtube" },
  { id: 10, name: "Reddit" },
]);

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
        'bg-primary text-primary-content hover:bg-primary-focus':
          isTagPicked(tag),
      }"
      v-for="tag in availableTags"
      :key="tag.id"
      @click="toggleTagPicked(tag)"
    >
      {{ tag.name }}
    </button>
  </div>
</template>
