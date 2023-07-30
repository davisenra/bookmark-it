<script setup lang="ts">
definePageMeta({
  middleware: "auth",
});
</script>

<template>
  <div class="container mx-auto mt-6 flex-grow px-3">
    <h1 class="prose-2xl font-bold">New bookmark</h1>
    <div class="divider my-2"></div>
    <FormCreateBookmark />
  </div>
</template>
