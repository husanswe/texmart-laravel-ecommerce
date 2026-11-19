<script setup lang="ts">
import type { Category } from '~/types'

defineProps<{ category: Category }>()
</script>

<template>
  <NuxtLink
    :to="`/c/${category.slug}`"
    class="group relative flex min-h-33 flex-col overflow-hidden rounded-lg border border-line bg-canvas p-4 transition-colors hover:border-brand-300 sm:min-h-37.5 sm:p-5"
  >
    <!-- From sm up, right padding reserves the icon's corner so long names
         wrap instead of running under it. -->
    <h3 class="text-h3-m text-ink-900 sm:pr-18 md:text-h3">
      {{ category.name }}
    </h3>
    <p class="mt-1 text-small text-ink-500 tnum sm:pr-18">
      {{ category.products_count ?? 0 }} ta mahsulot
    </p>

    <!-- Category icon (Tabler, via CategoryIcon).
         Phones: in normal flow, bottom-right on its own row. Two tiles share a
         360px row there, and single long words like "Smartfonlar" can't wrap,
         so a corner icon would overlap them.
         sm and up: absolute in the top-right corner. -->
    <CategoryIcon
      :name="category.icon"
      class="mt-auto size-10 self-end stroke-[1.5] text-brand-500 sm:absolute sm:top-5 sm:right-5 sm:mt-0 sm:size-14"
    />
  </NuxtLink>
</template>
