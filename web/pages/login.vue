<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";

definePageMeta({
    middleware: "guest",
    layout: "auth",
});

const authStore = useAuthStore();

const failedAuthentication = ref(false);
const failedAuthenticationFeedback = ref("");
const isAuthenticating = ref(false);

const credentials = ref({
    email: "",
    password: "",
});

async function handleLoginAttempt(): Promise<void> {
    if (!credentials.value.email || !credentials.value.password || failedAuthentication.value) {
        return;
    }

    try {
        isAuthenticating.value = true;
        await authStore.login(credentials.value);
    } catch (err: any) {
        failedAuthentication.value = true;
        failedAuthenticationFeedback.value = err.message;
    } finally {
        isAuthenticating.value = false;
    }
}

function resetForm(): void {
    if (failedAuthentication.value === false) {
        return;
    }

    failedAuthentication.value = false;
    failedAuthenticationFeedback.value = "";
}
</script>

<template>
    <div>
        <form @submit.prevent="handleLoginAttempt" class="max-w-xl">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input
                    @input="resetForm"
                    v-model="credentials.email"
                    type="text"
                    placeholder="Email"
                    class="input input-bordered"
                    :class="[failedAuthentication ? 'input-error' : '']"
                />
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input
                    @input="resetForm"
                    v-model="credentials.password"
                    type="password"
                    placeholder=""
                    class="input input-bordered"
                    :class="[failedAuthentication ? 'input-error' : '']"
                />
            </div>
            <div v-if="failedAuthenticationFeedback" class="mt-2">
                <p class="prose-sm text-error">{{ failedAuthenticationFeedback }}</p>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn" :disabled="isAuthenticating">
                    <span v-if="!isAuthenticating">
                        <Icon name="ph:sign-in-bold" size="20" />
                    </span>
                    <span v-else class="loading loading-spinner"></span>
                    <span>Login</span>
                </button>
            </div>
        </form>
        <div class="divider my-2"></div>
        <div class="mb-3 text-center">
            <NuxtLink to="/signup" class="link">Sign up</NuxtLink>
        </div>
    </div>
</template>
