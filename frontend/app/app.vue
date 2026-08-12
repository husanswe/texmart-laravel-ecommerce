<script setup lang="ts">
useHead({
  titleTemplate: (title?: string) => (title ? `${title} — Texmart` : 'Texmart'),
})
</script>

<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>
