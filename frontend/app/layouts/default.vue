<script setup lang="ts">
// The category tree feeds the header, mega-menu and mobile drawer. It is
// fetched once here rather than in each of them.
const { data: categories } = await useAsyncData('categories', () => listCategories(), {
  default: () => [],
})
</script>

<template>
  <div class="flex min-h-dvh flex-col bg-canvas">
    <AppHeader :categories="categories" />

    <!-- pb-14 clears the mobile tab bar, which is fixed over the page. -->
    <main class="flex-1 pb-14 lg:pb-0">
      <slot />
    </main>

    <AppFooter />
    <MobileTabBar />
    <ToastHost />
  </div>
</template>
