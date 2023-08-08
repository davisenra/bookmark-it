<template>
  <CoreSidebar>
    <div class="flex min-h-screen flex-col">
      <CoreNavbar />
      <div class="flex-grow">
        <slot />
      </div>
      <CoreFooter />
    </div>
  </CoreSidebar>
</template>
