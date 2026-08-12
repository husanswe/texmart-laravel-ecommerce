<script setup lang="ts">
import { Star } from '@lucide/vue'

const props = withDefaults(
  defineProps<{
    value: number
    /** Review count, printed after the stars as `(128)`. */
    count?: number
    size?: 'sm' | 'md'
    showValue?: boolean
  }>(),
  { count: undefined, size: 'sm', showValue: false },
)

// Each star is clipped to the fraction of it that is earned, so 4.3 reads as 4.3.
const fills = computed(() =>
  Array.from({ length: 5 }, (_, i) => Math.min(1, Math.max(0, props.value - i)) * 100),
)
</script>

<template>
  <span class="inline-flex items-center gap-1.5">
    <span
      class="inline-flex items-center gap-0.5"
      role="img"
      :aria-label="`Reyting: ${value.toFixed(1)} / 5`"
    >
      <span
        v-for="(fill, i) in fills"
        :key="i"
        class="relative inline-block"
        :class="size === 'sm' ? 'size-3.5' : 'size-4'"
      >
        <Star class="absolute inset-0 size-full text-line" aria-hidden="true" />
        <span class="absolute inset-0 overflow-hidden" :style="{ width: `${fill}%` }">
          <Star
            class="size-full fill-install text-install"
            :class="size === 'sm' ? 'size-3.5' : 'size-4'"
            aria-hidden="true"
          />
        </span>
      </span>
    </span>

    <span v-if="showValue" class="text-small text-ink-700 tnum">{{ value.toFixed(1) }}</span>
    <span v-if="count !== undefined" class="text-small text-ink-500 tnum">({{ count }})</span>
  </span>
</template>
