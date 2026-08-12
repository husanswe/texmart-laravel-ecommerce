<script setup lang="ts">
import { ChevronDown } from '@lucide/vue'

export interface SelectOption {
  value: string
  label: string
}

withDefaults(
  defineProps<{
    modelValue?: string
    options: SelectOption[]
    label?: string
    /** Rendered as a visually hidden label when there is no visible one. */
    srLabel?: string
    disabled?: boolean
    error?: string
  }>(),
  {
    modelValue: '',
    label: undefined,
    srLabel: undefined,
    disabled: false,
    error: undefined,
  },
)

defineEmits<{ 'update:modelValue': [value: string] }>()

const id = useId()
</script>

<template>
  <div class="w-full">
    <label v-if="label" :for="id" class="mb-1.5 block text-small text-ink-700">{{ label }}</label>
    <label v-else-if="srLabel" :for="id" class="sr-only">{{ srLabel }}</label>

    <div class="relative">
      <select
        :id="id"
        :value="modelValue"
        :disabled="disabled"
        :aria-invalid="error ? 'true' : undefined"
        class="h-11 w-full appearance-none rounded-md border bg-surface pl-3 pr-9 text-body text-ink-900 transition-colors outline-none hover:border-ink-300 focus:border-brand-500 disabled:cursor-not-allowed disabled:bg-canvas disabled:text-ink-300"
        :class="error ? 'border-out' : 'border-line'"
        @change="$emit('update:modelValue', ($event.target as HTMLSelectElement).value)"
      >
        <option v-for="option in options" :key="option.value" :value="option.value">
          {{ option.label }}
        </option>
      </select>
      <ChevronDown
        class="pointer-events-none absolute inset-y-0 right-3 my-auto size-4 text-ink-500"
        aria-hidden="true"
      />
    </div>

    <p v-if="error" class="mt-1.5 text-small text-out">{{ error }}</p>
  </div>
</template>
