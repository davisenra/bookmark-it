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
  <div class="overflow-x-auto overflow-y-clip">
    <table class="table">
      <thead>
        <tr>
          <th class="w-4">#</th>
          <th>Title</th>
          <th>Visited</th>
          <th>Visited at</th>
          <th class="w-36">Actions</th>
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
            <div class="flex flex-col gap-2">
              {{
                bookmark.title.length > 40
                  ? bookmark.title.slice(0, 40) + "..."
                  : bookmark.title
              }}
              <div class="flex space-x-1">
                <BookmarkTagBadge
                  v-for="tag in bookmark.tags"
                  :key="tag.id"
                  :tag="tag"
                />
              </div>
            </div>
          </td>
          <td>
            <div
              v-if="bookmark.visited"
              class="badge badge-success h-8 rounded-full"
            >
              <Icon name="ph:check-bold" />
            </div>
            <div v-else class="badge badge-error h-8 rounded-full">
              <Icon name="ph:x-bold" />
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
              <a :href="bookmark.url" class="btn btn-sm" target="_blank">
                <Icon name="ph:link" size="18" />
              </a>
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
