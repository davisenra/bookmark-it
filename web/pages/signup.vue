<script setup lang="ts">
definePageMeta({
    middleware: "guest",
    layout: "auth",
});
</script>

<template>
    <div>
        <form @submit.prevent="" class="max-w-xl">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" placeholder="name" class="input input-bordered" />
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="text" placeholder="Email" class="input input-bordered" />
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" placeholder="" class="input input-bordered" />
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Confirm password</span>
                </label>
                <input type="password" placeholder="" class="input input-bordered" />
            </div>
            <div class="mt-4">
                <button type="submit" class="btn"><Icon name="ph:sign-in-bold" size="20" />Sign up</button>
            </div>
        </form>
        <div class="divider my-2"></div>
        <div class="mb-3 text-center">
            <NuxtLink to="/login" class="link">Login</NuxtLink>
        </div>
    </div>
</template>
