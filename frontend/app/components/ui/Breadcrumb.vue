<script setup lang="ts">
import { ChevronRight } from '@lucide/vue'

export interface Crumb {
  label: string
  to?: string
}

defineProps<{ items: Crumb[] }>()
</script>

<template>
  <nav aria-label="Sahifa yo'li">
    <ol class="flex flex-wrap items-center gap-x-1.5 gap-y-1 text-small text-ink-500">
      <li v-for="(item, i) in items" :key="i" class="flex items-center gap-1.5">
        <NuxtLink
          v-if="item.to && i < items.length - 1"
          :to="item.to"
          class="transition-colors hover:text-brand-700"
        >
          {{ item.label }}
        </NuxtLink>
        <span v-else class="text-ink-700" :aria-current="i === items.length - 1 ? 'page' : undefined">
          {{ item.label }}
        </span>
        <ChevronRight
          v-if="i < items.length - 1"
          class="size-3.5 text-ink-300"
          aria-hidden="true"
        />
      </li>
    </ol>
  </nav>
</template>
