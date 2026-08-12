<script setup lang="ts">
import { Check } from '@lucide/vue'

withDefaults(
  defineProps<{
    modelValue?: boolean
    label?: string
    /** Facet count, printed right-aligned in grey: `8 GB (12)`. */
    count?: number
    disabled?: boolean
  }>(),
  { modelValue: false, label: undefined, count: undefined, disabled: false },
)

defineEmits<{ 'update:modelValue': [value: boolean] }>()
</script>

<template>
  <label
    class="group flex cursor-pointer items-center gap-2.5 py-1.5 select-none"
    :class="disabled && 'cursor-not-allowed opacity-50'"
  >
    <span class="relative flex size-[18px] shrink-0 items-center justify-center">
      <input
        type="checkbox"
        :checked="modelValue"
        :disabled="disabled"
        class="peer size-[18px] cursor-pointer appearance-none rounded-sm border border-line bg-surface transition-colors checked:border-brand-500 checked:bg-brand-500 disabled:cursor-not-allowed group-hover:border-brand-300 checked:group-hover:border-brand-600"
        @change="$emit('update:modelValue', ($event.target as HTMLInputElement).checked)"
      />
      <Check
        class="pointer-events-none absolute size-3 text-white opacity-0 peer-checked:opacity-100"
        :stroke-width="3"
        aria-hidden="true"
      />
    </span>

    <span v-if="label" class="text-body text-ink-700 group-hover:text-ink-900">{{ label }}</span>
    <slot />
    <span v-if="count !== undefined" class="ml-auto text-small text-ink-300 tnum">{{ count }}</span>
  </label>
</template>
