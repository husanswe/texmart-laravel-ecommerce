<script setup lang="ts">
const route = useRoute()
</script>

<template>
  <div class="container-page py-8">
    <h1 class="text-h2">{{ route.params.slug }}</h1>
  </div>
</template>