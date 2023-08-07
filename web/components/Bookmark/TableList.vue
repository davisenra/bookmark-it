<script setup lang="ts">
import { Bookmark } from "@/types/types";
import { useBookmarkStore } from "@/stores/bookmark";

const bookmarkStore = useBookmarkStore();

defineProps<{
  bookmarks: Bookmark[];
}>();

defineEmits(["update"]);
</script>

<template>
  <div class="overflow-y-hidden">
    <table class="table">
      <thead>
        <tr>
          <th class="w-6">#</th>
          <th>Title</th>
          <th>Visited</th>
          <th>Tags</th>
          <th>Visited at</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover" v-for="bookmark in bookmarks" :key="bookmark.id">
          <td>
            <div
              v-if="bookmark.description"
              class="dropdown-start dropdown-hover dropdown"
            >
              <label tabindex="0" class="btn btn-square btn-ghost btn-sm m-1">
                <Icon name="ph:info" size="24" />
              </label>
              <div
                class="dropdown-content rounded-box z-[1] w-52 bg-base-100 p-3 shadow"
              >
                <p class="prose-sm">{{ bookmark.description }}</p>
              </div>
            </div>
          </td>
          <td class="w-2/6">
            {{ bookmark.title }}
          </td>
          <td>
            <div v-if="bookmark.visited" class="badge badge-success">
              <Icon name="ph:check-bold" />
            </div>
            <div v-else class="badge badge-error">
              <Icon name="ph:x-bold" />
            </div>
          </td>
          <td class="space-x-2">
            <BookmarkTagBadge :tag="bookmark.tags[0]" />
            <div v-if="bookmark.tags.length > 1" class="badge badge-secondary">
              +{{ bookmark.tags.length }}
            </div>
          </td>
          <td>
            {{
              bookmark.visited_at
                ? new Date(bookmark.visited_at).toDateString()
                : ""
            }}
          </td>
          <td>
            <div class="flex space-x-2">
              <ButtonConfirm
                @confirm="
                  bookmarkStore.markBookmarkAsVisited(bookmark.id);
                  $emit('update');
                "
              />
              <ButtonDelete
                @delete="
                  bookmarkStore.deleteBookmark(bookmark.id);
                  $emit('update');
                "
              />
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
