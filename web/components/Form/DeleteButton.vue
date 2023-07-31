<script setup lang="ts">
const confirmDelete = ref(false);
const emit = defineEmits(["delete"]);

function handleClick(): void {
  startDeleteTimer();
  confirmDelete.value = true;
}

function startDeleteTimer(): void {
  setTimeout(() => {
    confirmDelete.value = false;
  }, 2000);
}
</script>

<template>
  <div>
    <button
      v-if="!confirmDelete"
      @click="handleClick"
      class="btn btn-error btn-sm"
    >
      <Icon name="ph:trash-bold" />
    </button>
    <span v-else>
      <button @click="emit('delete')" class="btn btn-error btn-sm">
        <Icon name="ph:check-bold" />
      </button>
    </span>
  </div>
</template>
