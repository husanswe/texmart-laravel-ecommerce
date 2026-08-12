<script setup lang="ts">
import { X } from '@lucide/vue'

withDefaults(
  defineProps<{
    /** Selected chips are used for variant pickers and active filter state. */
    selected?: boolean
    /** Adds a remove button — active filter chips above the results grid. */
    removable?: boolean
    disabled?: boolean
    /** Unavailable variant combinations render struck through, not hidden. */
    unavailable?: boolean
    /** Static chips are plain labels with no press behaviour. */
    as?: 'button' | 'span'
    removeLabel?: string
  }>(),
  {
    selected: false,
    removable: false,
    disabled: false,
    unavailable: false,
    as: 'button',
    removeLabel: 'Olib tashlash',
  },
)

defineEmits<{ select: []; remove: [] }>()
</script>

<template>
  <component
    :is="as"
    :type="as === 'button' ? 'button' : undefined"
    :disabled="as === 'button' ? disabled || unavailable : undefined"
    :aria-pressed="as === 'button' && !removable ? selected : undefined"
    class="inline-flex h-9 items-center gap-1.5 rounded-sm border px-3 text-small transition-colors"
    :class="[
      selected
        ? 'border-brand-500 bg-brand-50 text-brand-700'
        : 'border-line bg-surface text-ink-700',
      !disabled && !unavailable && as === 'button' && 'hover:border-brand-300 hover:text-brand-700',
      unavailable && 'cursor-not-allowed text-ink-300 line-through',
      disabled && 'cursor-not-allowed opacity-50',
    ]"
    @click="as === 'button' && !removable ? $emit('select') : undefined"
  >
    <slot />
    <button
      v-if="removable"
      type="button"
      class="-mr-1 grid size-5 place-items-center rounded-sm text-ink-500 transition-colors hover:bg-canvas hover:text-ink-900"
      :aria-label="removeLabel"
      @click.stop="$emit('remove')"
    >
      <X class="size-3.5" aria-hidden="true" />
    </button>
  </component>
</template>
