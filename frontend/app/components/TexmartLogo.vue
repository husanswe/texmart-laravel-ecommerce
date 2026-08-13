<script setup lang="ts">
withDefaults(
  defineProps<{
    /** `dark` is the footer treatment on the ink-900 background. */
    tone?: 'brand' | 'dark'
    size?: 'md' | 'lg'
  }>(),
  { tone: 'brand', size: 'md' },
)
</script>

<template>
  <span
    class="inline-flex items-baseline font-bold tracking-[-0.03em] select-none"
    :class="[
      tone === 'brand' ? 'text-brand-500' : 'text-white',
      size === 'lg' ? 'text-[30px]' : 'text-[26px]',
    ]"
  >
    Texmart
  </span>
</template>
