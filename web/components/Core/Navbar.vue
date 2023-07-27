<script setup lang="ts"></script>

<template>
  <div class="navbar bg-base-100">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost btn-circle">
          <Icon name="ic:baseline-menu" size="24" />
        </label>
        <ul
          tabindex="0"
          class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52"
        >
          <li><a>Home</a></li>
          <li><a>Logout</a></li>
        </ul>
      </div>
    </div>
    <div class="navbar-center space-x-1">
      <NuxtLink to="/" class="btn btn-ghost flex items-center">
        <Icon name="ph:book-bookmark-bold" size="24" />
        <p class="normal-case text-xl">Bookmark It</p>
      </NuxtLink>
    </div>
    <div class="navbar-end"></div>
  </div>
</template>
