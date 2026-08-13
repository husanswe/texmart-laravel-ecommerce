<script setup lang="ts">
import { ArrowRight } from '@lucide/vue'

withDefaults(
  defineProps<{
    eyebrow?: string
    title: string
    body?: string
    cta: string
    to: string
    tone?: 'brand' | 'install' | 'plain'
  }>(),
  { eyebrow: undefined, body: undefined, tone: 'brand' },
)

const TONE = {
  brand: 'bg-brand-50 border-brand-100 text-ink-900',
  install: 'bg-install-bg border-install-bg text-ink-900',
  plain: 'bg-canvas border-line text-ink-900',
} as const
</script>

<template>
  <NuxtLink
    :to="to"
    class="group flex min-h-[104px] flex-col justify-center rounded-lg border p-5 transition-colors hover:border-brand-300 lg:min-h-[152px]"
    :class="TONE[tone]"
  >
    <p v-if="eyebrow" class="text-micro uppercase text-ink-500">{{ eyebrow }}</p>
    <h3 class="mt-1 max-w-[20ch] text-h3-m md:text-h3">{{ title }}</h3>
    <p v-if="body" class="mt-1 max-w-[34ch] text-small text-ink-500">{{ body }}</p>
    <span class="mt-3 inline-flex items-center gap-1.5 text-small font-semibold text-brand-700">
      {{ cta }}
      <ArrowRight class="size-4 transition-transform group-hover:translate-x-0.5" aria-hidden="true" />
    </span>
  </NuxtLink>
</template>
