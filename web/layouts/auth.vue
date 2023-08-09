<template>
    <div class="bg-base-200">
        <div class="container mx-auto flex min-h-screen items-center justify-center px-3">
            <div class="w-full max-w-lg bg-base-100 px-6 py-3 shadow">
                <div class="mt-2 flex items-center justify-center space-x-2">
                    <Icon name="ph:book-bookmark-bold" size="32" />
                    <p class="text-2xl font-bold">Bookmark It</p>
                </div>
                <div class="divider"></div>
                <slot />
            </div>
        </div>
    </div>
</template>
