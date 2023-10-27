import { defineStore } from "pinia";
import { type Tag, type Bookmark } from "@/types/types";

export type DashboardResponse = {
    data: {
        bookmarks: Bookmark[];
        total_bookmarks: number;
        total_bookmarks_week: number;
        bookmarks_unvisited: number;
        tags: Tag[];
        total_tags: number;
    };
};

export const useDashboardStore = defineStore("dashboard", () => {
    async function getDashboardData() {
        const res = await useApiFetch(`/v1/dashboard`, {
            method: "GET",
        });

        const data: DashboardResponse = await res?.json();

        return data.data;
    }

    return {
        getDashboardData,
    };
});
