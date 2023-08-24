<script setup lang="ts">
defineProps({
    title: {
        required: true,
        type: String,
    },
    stat: {
        required: true,
        type: Number,
    },
    description: {
        required: false,
        type: String,
    },
});
</script>
<template>
    <div class="w-full rounded p-3 shadow-md">
        <p class="text-lg font-bold">{{ title }}</p>
        <p class="text-3xl font-extrabold">{{ stat }}</p>
        <p class="text-sm" v-if="description">{{ description }}</p>
    </div>
</template>
