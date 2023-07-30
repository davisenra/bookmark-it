<script setup lang="ts">
const bookmark = ref({
  title: "",
  url: "",
  description: "",
  tags: [],
});

function handleBookmarkCreation() {}

function generateTitle(): void {
  try {
    const newTitle = useTitleGenerator(bookmark.value.url);
    bookmark.value.title = newTitle;
  } catch (e) {
    return;
  }
}
</script>

<template>
  <form @submit.prevent="handleBookmarkCreation" class="max-w-xl">
    <div class="form-control w-full">
      <label class="label">
        <span class="label-text">Title</span>
      </label>
      <input
        v-model="bookmark.title"
        type="text"
        placeholder="Title"
        class="input input-bordered"
      />
    </div>
    <div class="form-control w-full">
      <label class="label">
        <span class="label-text">URL</span>
      </label>
      <div>
        <input
          v-model="bookmark.url"
          type="text"
          placeholder="https://"
          class="input input-bordered w-full pr-12"
        />
        <button
          class="btn btn-circle btn-ghost btn-sm fixed -ml-10 mt-2"
          @click="generateTitle"
        >
          <Icon name="ph:lightbulb" />
        </button>
      </div>
    </div>
    <div class="form-control w-full">
      <label class="label">
        <span class="label-text">Description </span>
      </label>
      <textarea
        v-model="bookmark.description"
        class="textarea textarea-bordered h-24"
        placeholder="Description"
      ></textarea>
    </div>
    <div class="form-control w-full">
      <label class="label">
        <span class="label-text">Tags</span>
      </label>
      <FormTagPicker :picked-tags-bag="bookmark.tags" />
    </div>
    <button type="submit" class="btn btn-primary my-3">
      <Icon name="ph:floppy-disk-bold" size="20" /> Save
    </button>
  </form>
</template>
