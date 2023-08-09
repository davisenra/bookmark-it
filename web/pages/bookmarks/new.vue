<script setup lang="ts">
definePageMeta({
    middleware: "auth",
});
</script>

<template>
    <div>
        <h1 class="prose-2xl font-bold">New bookmark</h1>
        <div class="divider my-2"></div>
        <BookmarkCreateForm />
    </div>
</template>
