<script setup lang="ts">
import type { Alert } from "@/composables/useAlert";
import { alerts, removeAlert, AlertType } from "@/composables/useAlert";

const alertColor = (alert: Alert) => {
    switch (alert.type) {
        case AlertType.SUCCESS:
            return "alert-success";
        case AlertType.INFO:
            return "alert-info";
        case AlertType.ERROR:
            return "alert-error";
        case AlertType.WARNING:
            return "alert-warning";
        default:
            return "alert-info";
    }
};
</script>

<template>
    <div class="toast toast-end">
        <div
            class="alert cursor-pointer transition-all hover:shadow-md"
            :class="alertColor(alert)"
            v-for="alert in alerts"
            :key="alert.message"
            @click="removeAlert(alert)"
        >
            <span>{{ alert.message }}</span>
        </div>
    </div>
</template>
