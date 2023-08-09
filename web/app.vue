<template>
    <NuxtLayout>
        <NuxtPage />
    </NuxtLayout>
</template>

<style>
.page-enter-active,
.page-leave-active {
    transition: opacity 0.2s;
}
.page-enter,
.page-leave-active {
    opacity: 0;
}
</style>
