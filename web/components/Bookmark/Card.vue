<script setup lang="ts">
import { Bookmark } from "types/types";

const { bookmark } = defineProps<{ bookmark: Bookmark }>();
</script>

<template>
  <div
    class="flex flex-col rounded border border-t-4 p-4 shadow-md"
    :class="[bookmark.visited ? 'border-t-success' : 'border-t-base']"
  >
    <div class="flex flex-grow justify-between">
      <p class="prose-lg font-bold">
        {{ bookmark.title }}
      </p>
      <div>
        <div
          v-if="bookmark.description"
          class="tooltip"
          :data-tip="bookmark.description"
        >
          <button class="btn btn-square btn-ghost btn-sm">
            <Icon name="ph:info" size="24" />
          </button>
        </div>
        <div class="dropdown dropdown-hover">
          <label tabindex="0" class="btn btn-square btn-ghost btn-sm m-1">
            <Icon name="ph:dots-three-outline-vertical-fill" size="20" />
          </label>
          <ul
            tabindex="0"
            class="menu dropdown-content rounded-box z-[1] w-52 bg-base-100 p-2 shadow"
          >
            <li>
              <button>
                <Icon name="ph:check-bold" size="18" />Mark as visited
              </button>
            </li>
            <li>
              <button><Icon name="ph:trash" size="18" />Remove</button>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="my-3 flex flex-wrap gap-2">
      <BookmarkTagBadge v-for="tag in bookmark.tags" :key="tag.id" :tag="tag" />
    </div>
    <a class="btn btn-ghost btn-sm w-max" :href="bookmark.url" target="_blank">
      <Icon name="ph:link" size="18" />Visit
    </a>
  </div>
</template>
