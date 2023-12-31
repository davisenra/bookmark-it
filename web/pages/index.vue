<script setup lang="ts">
import { useDashboardStore } from "@/stores/dashboard";

definePageMeta({
    middleware: "auth",
});

const dashboardStore = useDashboardStore();
const dashboardData = await dashboardStore.getDashboardData();
const unreadBookmarksPercentage = computed(() => {
    const percentage = (dashboardData.bookmarks_unvisited * 100) / dashboardData.total_bookmarks;
    return parseInt(percentage.toString());
});
</script>

<template>
    <div class="flex flex-col space-y-6 rounded-md bg-white p-6 shadow-md">
        <div>
            <h1 class="prose-2xl font-bold">Dashboard</h1>
            <div class="divider my-2"></div>
            <div class="grid gap-3 md:grid-cols-2">
                <DashboardCard>
                    <div class="bg-primary w-max rounded-full bg-opacity-10 p-3">
                        <Icon name="ph:bookmark-bold" class="text-primary" size="36" />
                    </div>
                    <div>
                        <p class="text-primary text-4xl font-extrabold">
                            {{ dashboardData.total_bookmarks }}
                        </p>
                    </div>
                    <p class="prose-xl text-primary font-bold">Bookmarks</p>
                </DashboardCard>
                <DashboardCard>
                    <div class="bg-accent w-max rounded-full bg-opacity-10 p-3">
                        <Icon name="ph:tag-bold" class="text-accent" size="36" />
                    </div>
                    <div>
                        <p class="text-accent text-4xl font-extrabold">
                            {{ dashboardData.total_tags }}
                        </p>
                    </div>
                    <p class="prose-xl text-accent font-bold">Tags</p>
                </DashboardCard>
            </div>
        </div>
        <div>
            <h1 class="prose-2xl font-bold">Stats</h1>
            <div class="divider my-2"></div>
            <div class="grid gap-3 md:grid-cols-2">
                <DashboardStat title="Bookmarks created this week" :stat="dashboardData.total_bookmarks_week" />
                <DashboardStat
                    title="Unread bookmarks"
                    :stat="dashboardData.bookmarks_unvisited"
                    :description="unreadBookmarksPercentage + '% of total bookmarks'"
                />
            </div>
        </div>
    </div>
</template>
