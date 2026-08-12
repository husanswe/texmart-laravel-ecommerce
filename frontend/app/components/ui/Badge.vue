<script setup lang="ts">
type Tone = 'discount' | 'out' | 'stock' | 'install' | 'brand' | 'neutral'

withDefaults(defineProps<{ tone?: Tone }>(), { tone: 'neutral' })

// Badges are the one place micro type appears. They never carry an icon.
const TONE_CLASS: Record<Tone, string> = {
  discount: 'bg-out text-white',
  out: 'bg-ink-500 text-white',
  stock: 'bg-stock text-white',
  install: 'bg-install-bg text-install',
  brand: 'bg-brand-500 text-white',
  neutral: 'bg-canvas text-ink-500 border border-line',
}
</script>

<template>
  <span
    class="inline-flex h-[22px] items-center rounded-sm px-2 text-micro uppercase tnum"
    :class="TONE_CLASS[tone]"
  >
    <slot />
  </span>
</template>
