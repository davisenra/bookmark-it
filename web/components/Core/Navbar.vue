<script setup lang="ts"></script>

<template>
  <div class="navbar px-2 shadow lg:px-6">
    <div class="navbar-start">
      <label
        for="sidebar-drawer"
        class="btn btn-square btn-ghost drawer-button lg:hidden"
      >
        <Icon name="ic:baseline-menu" size="24" />
      </label>
    </div>
    <div class="navbar-center">
      <NuxtLink to="/" class="btn btn-ghost flex items-center">
        <Icon name="ph:book-bookmark-bold" size="24" />
        <p class="text-xl normal-case">Bookmark It</p>
      </NuxtLink>
    </div>
    <div class="navbar-end">
      <NuxtLink to="/bookmarks/new" class="btn btn-primary">
        <Icon name="ph:bookmark-simple-fill" size="18" />
        <span class="hidden sm:block">New bookmark</span>
      </NuxtLink>
    </div>
  </div>
</template>
