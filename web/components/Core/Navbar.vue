<script setup lang="ts"></script>

<template>
  <div class="navbar shadow">
    <div class="navbar-start">
      <label
        for="sidebar-drawer"
        class="btn btn-square btn-ghost drawer-button"
      >
        <Icon name="ic:baseline-menu" size="24" />
      </label>
    </div>
    <div class="navbar-center space-x-1">
      <NuxtLink to="/" class="btn btn-ghost flex items-center">
        <Icon name="ph:book-bookmark-bold" size="24" />
        <p class="text-xl normal-case">Bookmark It</p>
      </NuxtLink>
    </div>
    <div class="navbar-end">
      <NuxtLink to="/new-bookmark" class="btn btn-primary">
        <Icon name="ph:bookmark-simple-fill" size="18" /> New bookmark
      </NuxtLink>
    </div>
  </div>
</template>
