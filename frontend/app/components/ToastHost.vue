<script setup lang="ts">
const { toasts, dismiss } = useToast()
</script>

<template>
  <ClientOnly>
    <Teleport to="body">
      <!-- Above the compare tray and the mobile tab bar, out of the way of both. -->
      <div
        class="pointer-events-none fixed inset-x-0 bottom-0 z-[60] flex flex-col items-center gap-2 px-4 pb-[calc(env(safe-area-inset-bottom)+96px)] sm:items-end sm:pb-[calc(env(safe-area-inset-bottom)+24px)] sm:pr-6"
        aria-live="polite"
      >
        <UiToast
          v-for="toast in toasts"
          :key="toast.id"
          :tone="toast.tone"
          :message="toast.message"
          @dismiss="dismiss(toast.id)"
        />
      </div>
    </Teleport>
  </ClientOnly>
</template>
