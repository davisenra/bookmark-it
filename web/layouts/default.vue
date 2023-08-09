<template>
  <CoreSidebar>
    <div class="flex min-h-screen flex-col">
      <NuxtLoadingIndicator color="false" />
      <CoreNavbar />
      <div class="container mx-auto my-6 flex-grow px-3 lg:px-6">
        <slot />
      </div>
      <CoreFooter />
    </div>
  </CoreSidebar>
</template>
