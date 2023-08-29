<script setup lang="ts">
definePageMeta({
    middleware: "auth",
});
</script>

<template>
    <div class="flex flex-col space-y-6 rounded-md bg-white p-6 shadow-md">
        <div>
            <h1 class="prose-2xl font-bold">New tag</h1>
            <div class="divider my-2"></div>
            <TagCreateForm />
        </div>
        <div>
            <h1 class="prose-2xl font-bold">Tags</h1>
            <div class="divider my-2"></div>
            <TagTable />
        </div>
    </div>
</template>
