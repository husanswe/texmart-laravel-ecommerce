<script setup lang="ts">
import type { Locale } from '~/stores/locale'

/**
 * The two national flags, drawn inline. Lucide has no flag set and emoji are
 * not used as UI icons, so these are hand-drawn at a 3:2 ratio. They are
 * decorative — the adjacent text names the language — hence aria-hidden.
 */
defineProps<{ locale: Locale }>()
</script>

<template>
  <span
    class="inline-block shrink-0 overflow-hidden rounded-[2px] border border-line"
    aria-hidden="true"
  >
    <!-- Uzbekistan: blue / white / green with red fimbriations -->
    <svg
      v-if="locale === 'uz'"
      viewBox="0 0 30 20"
      class="block size-full"
      role="presentation"
      focusable="false"
    >
      <rect width="30" height="20" fill="#fff" />
      <rect width="30" height="6.2" fill="#0099B5" />
      <rect y="13.8" width="30" height="6.2" fill="#1EB53A" />
      <rect y="6.2" width="30" height="0.9" fill="#CE1126" />
      <rect y="12.9" width="30" height="0.9" fill="#CE1126" />
      <circle cx="6" cy="3.1" r="2.1" fill="#fff" />
      <circle cx="6.9" cy="3.1" r="2.1" fill="#0099B5" />
    </svg>

    <!-- Russia: white / blue / red -->
    <svg v-else viewBox="0 0 30 20" class="block size-full" role="presentation" focusable="false">
      <rect width="30" height="20" fill="#fff" />
      <rect y="6.67" width="30" height="6.67" fill="#0039A6" />
      <rect y="13.34" width="30" height="6.66" fill="#D52B1E" />
    </svg>
  </span>
</template>
