<script setup lang="ts"></script>

<template>
  <form class="w-full max-w-xl">
    <div class="form-control w-full">
      <label class="label">
        <span class="label-text">Tag</span>
      </label>
      <input type="text" placeholder="Tag" class="input input-bordered" />
    </div>
    <div class="mt-4">
      <button type="submit" class="btn btn-primary">
        <Icon name="ph:floppy-disk-bold" size="20" /> Save
      </button>
    </div>
  </form>
</template>
