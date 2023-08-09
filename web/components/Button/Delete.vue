<script setup lang="ts">
const confirmDelete = ref(false);
const isSending = ref(false);
const emit = defineEmits(["delete"]);

function handleClick(): void {
  startDeleteTimer();
  confirmDelete.value = true;
}

function handleSecondClick(): void {
  isSending.value = true;
  emit("delete");
}

function startDeleteTimer(): void {
  setTimeout(() => {
    confirmDelete.value = false;
    isSending.value = false;
  }, 1500);
}
</script>

<template>
  <div>
    <button v-if="!confirmDelete" @click="handleClick" class="btn btn-sm">
      <Icon name="ph:trash-bold" />
    </button>
    <button
      v-else
      @click="handleSecondClick"
      class="btn btn-error btn-sm"
      :disabled="isSending"
    >
      <Icon name="ph:check-bold" />
    </button>
  </div>
</template>
