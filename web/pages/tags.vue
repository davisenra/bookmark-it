<script setup lang="ts">
definePageMeta({
  middleware: "auth",
});
</script>

<template>
  <div class="container mx-auto mt-6 flex flex-col space-y-6 px-3">
    <div>
      <h1 class="prose-2xl font-bold">New tag</h1>
      <div class="divider my-2"></div>
      <FormCreateTag />
    </div>
    <div>
      <h1 class="prose-2xl font-bold">Tags</h1>
      <div class="divider my-2"></div>
      <TagTableList />
    </div>
  </div>
</template>
