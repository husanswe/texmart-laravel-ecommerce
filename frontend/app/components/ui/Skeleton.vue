<script setup lang="ts">
withDefaults(
  defineProps<{
    /** Tailwind sizing classes for the block, e.g. `h-4 w-2/3`. */
    class?: string
    rounded?: 'sm' | 'md' | 'lg' | 'full'
  }>(),
  { class: 'h-4 w-full', rounded: 'sm' },
)

const ROUNDED = { sm: 'rounded-sm', md: 'rounded-md', lg: 'rounded-lg', full: 'rounded-full' }
</script>

<template>
  <!-- A single opacity pulse, not a shimmer sweep. Reduced motion stills it. -->
  <div class="animate-pulse bg-canvas" :class="[$props.class, ROUNDED[rounded]]" aria-hidden="true" />
</template>
