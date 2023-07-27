<script setup lang="ts"></script>

<template>
  <div class="btm-nav border-t-2">
    <NuxtLink to="/" active-class="active">
      <Icon name="ph:book-bookmark" size="32" />
    </NuxtLink>
    <NuxtLink to="/new-bookmark" active-class="active">
      <Icon name="ph:plus-circle-bold" size="32" />
    </NuxtLink>
  </div>
</template>
