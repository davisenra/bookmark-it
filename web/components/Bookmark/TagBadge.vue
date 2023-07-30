<script setup lang="ts">
import { Tag } from "types/types";

const { tag } = defineProps<{ tag: Tag }>();
</script>

<template>
  <div class="badge badge-accent">{{ tag.name }}</div>
</template>
