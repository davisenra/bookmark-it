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
    <table class="table table-xs">
      <thead>
        <tr>
          <th>Title</th>
          <th>Visited</th>
          <th>Visited at</th>
          <th>Created at</th>
          <th class="w-36">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover" v-for="bookmark in bookmarks" :key="bookmark.id">
          <td class="w-4/6">
            <div class="prose-sm flex flex-col gap-2">
              {{
                bookmark.title.length > 50
                  ? bookmark.title.slice(0, 50) + "..."
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
          <td class="w-4 text-center">
            <div
              v-if="bookmark.visited"
              class="badge badge-success badge-sm"
            ></div>
            <div v-else class="badge badge-error badge-sm"></div>
          </td>
          <td class="w-6">
            {{
              bookmark.visited_at
                ? new Date(bookmark.visited_at).toLocaleDateString()
                : ""
            }}
          </td>
          <td class="w-6">
            {{ new Date(bookmark.created_at).toLocaleDateString() }}
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
