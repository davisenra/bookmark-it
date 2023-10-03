<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";

definePageMeta({
    middleware: "guest",
    layout: "auth",
});

const authStore = useAuthStore();

type RegistrationPayload = {
    name: string;
    email: string;
    password: string;
    password_confirm: string;
};

async function submit(data: RegistrationPayload) {
    try {
        await authStore.register({
            name: data.name,
            email: data.email,
            password: data.password,
            password_confirmation: data.password_confirm,
        });
    } catch (error) {
        console.log(error);
    }
}
</script>

<template>
    <div>
        <FormKit type="form" :actions="false" @submit="submit">
            <FormKit validation="required" name="name" label="Name" type="text" placeholder="e.g: John Doe" />
            <FormKit validation="required|email" name="email" label="Email" type="text" placeholder="john@doe.com" />
            <FormKit validation="required|length:8,16" name="password" label="Password" type="password" />
            <FormKit validation="required|confirm" name="password_confirm" label="Confirm password" type="password" />
            <div class="mt-4">
                <button type="submit" class="btn"><Icon name="ph:sign-in-bold" size="20" />Sign up</button>
            </div>
        </FormKit>
        <div class="divider my-2"></div>
        <div class="mb-3 text-center">
            <NuxtLink to="/login" class="link">Login</NuxtLink>
        </div>
    </div>
</template>
