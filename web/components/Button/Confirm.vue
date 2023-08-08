<script setup lang="ts">
const confirmAction = ref(false);
const emit = defineEmits(["confirm"]);

function handleClick(): void {
  startDeleteTimer();
  confirmAction.value = true;
}

function startDeleteTimer(): void {
  setTimeout(() => {
    confirmAction.value = false;
  }, 2000);
}
</script>

<template>
  <div>
    <button v-if="!confirmAction" @click="handleClick" class="btn btn-sm">
      <Icon name="ph:check-square-bold" />
    </button>
    <button
      v-else
      @click="
        emit('confirm');
        confirmAction = false;
      "
      class="btn btn-success btn-sm"
    >
      <Icon name="ph:check-bold" />
    </button>
  </div>
</template>
