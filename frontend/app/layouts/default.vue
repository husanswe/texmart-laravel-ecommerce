<script setup lang="ts">
// The real header, footer, mobile tab bar and compare tray arrive in phase 3.
// Until then this layout only provides the page canvas so pages can be reviewed
// in isolation.
</script>

<template>
  <div class="flex min-h-dvh flex-col bg-canvas">
    <main class="flex-1">
      <slot />
    </main>
    <ToastHost />
  </div>
</template>
