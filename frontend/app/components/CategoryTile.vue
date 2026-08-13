<script setup lang="ts">
import type { Category } from '~/types'

defineProps<{ category: Category }>()
</script>

<template>
  <NuxtLink
    :to="`/c/${category.slug}`"
    class="group relative flex min-h-[132px] flex-col overflow-hidden rounded-lg border border-line bg-canvas p-4 transition-colors hover:border-brand-300 sm:min-h-[150px] sm:p-5"
  >
    <h3 class="relative z-10 max-w-[16ch] text-h3-m text-ink-900 md:text-h3">
      {{ category.name }}
    </h3>
    <p class="relative z-10 mt-1 text-small text-ink-500 tnum">
      {{ category.productCount }} ta mahsulot
    </p>

    <!-- The category mark bleeds out of the bottom-right corner and is clipped
         by the card, standing in for the product photograph. -->
    <CategoryIcon
      :name="category.icon"
      class="absolute -right-4 -bottom-5 size-28 text-brand-300/45 transition-colors group-hover:text-brand-300/70 sm:-right-5 sm:-bottom-6 sm:size-32"
    />
  </NuxtLink>
</template>
