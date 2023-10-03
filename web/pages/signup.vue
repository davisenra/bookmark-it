<script setup lang="ts">
definePageMeta({
    middleware: "guest",
    layout: "auth",
});

const registrationPayload = ref({
    name: "",
    email: "",
    password: "",
    passwordConfirmation: "",
});

const submit = () => {};
</script>

<template>
    <div>
        <FormKit type="form">
            <FormKit
                v-model="registrationPayload.name"
                validation="required"
                label="Name"
                type="text"
                placeholder="e.g: John Doe"
            />
            <FormKit
                v-model="registrationPayload.email"
                validation="required|email"
                label="Email"
                type="text"
                placeholder="john@doe.com"
            />
            <FormKit
                v-model="registrationPayload.password"
                validation="required|length:5,16"
                name="password"
                label="Password"
                type="password"
            />
            <FormKit
                v-model="registrationPayload.passwordConfirmation"
                validation="required|confirm"
                name="password_confirm"
                label="Confirm password"
                type="password"
            />
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
