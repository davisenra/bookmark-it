<script setup lang="ts">
const confirmAction = ref(false);
const isSending = ref(false);
const emit = defineEmits(["confirm"]);

function handleClick(): void {
  startDeleteTimer();
  confirmAction.value = true;
}

function handleSecondClick(): void {
  isSending.value = true;
  emit("confirm");
}

function startDeleteTimer(): void {
  setTimeout(() => {
    confirmAction.value = false;
    isSending.value = false;
  }, 1500);
}
</script>

<template>
  <div>
    <button v-if="!confirmAction" @click="handleClick" class="btn btn-sm">
      <Icon name="ph:check-square-bold" />
    </button>
    <button
      v-else
      @click="handleSecondClick"
      class="btn btn-success btn-sm"
      :disabled="isSending"
    >
      <Icon name="ph:check-bold" />
    </button>
  </div>
</template>
