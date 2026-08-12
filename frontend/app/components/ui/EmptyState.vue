<script setup lang="ts">
import type { Component } from 'vue'
import { PackageSearch } from '@lucide/vue'

withDefaults(
  defineProps<{
    icon?: Component
    title: string
    /** One line saying what to do next. An empty screen is never a dead end. */
    description?: string
  }>(),
  { icon: undefined, description: undefined },
)
</script>

<template>
  <div class="flex flex-col items-center rounded-lg border border-line bg-surface px-6 py-14 text-center">
    <div class="grid size-12 place-items-center rounded-lg bg-canvas text-ink-500">
      <component :is="icon ?? PackageSearch" class="size-6" aria-hidden="true" />
    </div>
    <h2 class="mt-4 text-h3-m text-ink-900 md:text-h3">{{ title }}</h2>
    <p v-if="description" class="mt-1.5 max-w-[46ch] text-body text-ink-500">{{ description }}</p>
    <div v-if="$slots.default" class="mt-5 flex flex-wrap justify-center gap-3">
      <slot />
    </div>
  </div>
</template>
