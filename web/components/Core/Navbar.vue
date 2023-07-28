<script setup lang="ts"></script>

<template>
  <div class="navbar bg-base-200">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-square btn-ghost">
          <Icon name="ic:baseline-menu" size="24" />
        </label>
        <ul
          tabindex="0"
          class="menu dropdown-content rounded-box menu-sm z-[1] mt-3 w-52 bg-base-100 p-2 shadow"
        >
          <li>
            <NuxtLink to="/" class="text-lg">
              <Icon name="ph:house" />Home
            </NuxtLink>
          </li>
          <li>
            <NuxtLink to="/login" class="text-lg">
              <Icon name="ph:sign-out" />Logout
            </NuxtLink>
          </li>
        </ul>
      </div>
    </div>
    <div class="navbar-center space-x-1">
      <NuxtLink to="/" class="btn btn-ghost flex items-center">
        <Icon name="ph:book-bookmark-bold" size="24" />
        <p class="text-xl normal-case">Bookmark It</p>
      </NuxtLink>
    </div>
    <div class="navbar-end"></div>
  </div>
</template>
