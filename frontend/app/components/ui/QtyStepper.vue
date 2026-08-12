<script setup lang="ts">
import { Minus, Plus } from '@lucide/vue'

const props = withDefaults(
  defineProps<{
    modelValue: number
    min?: number
    /** Usually the variant's stock, so the stepper cannot exceed it. */
    max?: number
    size?: 'sm' | 'md'
    label?: string
  }>(),
  { min: 1, max: 99, size: 'md', label: 'Miqdor' },
)

const emit = defineEmits<{ 'update:modelValue': [value: number] }>()

function set(next: number) {
  emit('update:modelValue', Math.min(props.max, Math.max(props.min, next)))
}

function onInput(event: Event) {
  const parsed = Number.parseInt((event.target as HTMLInputElement).value, 10)
  set(Number.isNaN(parsed) ? props.min : parsed)
}
</script>

<template>
  <div
    class="inline-flex items-center rounded-md border border-line bg-surface"
    :class="size === 'sm' ? 'h-9' : 'h-11'"
  >
    <button
      type="button"
      class="grid h-full place-items-center rounded-l-md text-ink-700 transition-colors hover:bg-canvas disabled:cursor-not-allowed disabled:text-ink-300 disabled:hover:bg-transparent"
      :class="size === 'sm' ? 'w-9' : 'w-11'"
      :disabled="modelValue <= min"
      :aria-label="`${label}ni kamaytirish`"
      @click="set(modelValue - 1)"
    >
      <Minus class="size-4" aria-hidden="true" />
    </button>

    <input
      :value="modelValue"
      type="text"
      inputmode="numeric"
      :aria-label="label"
      class="h-full w-10 border-x border-line bg-transparent text-center text-body font-semibold text-ink-900 outline-none tnum focus-visible:bg-brand-50"
      @input="onInput"
    />

    <button
      type="button"
      class="grid h-full place-items-center rounded-r-md text-ink-700 transition-colors hover:bg-canvas disabled:cursor-not-allowed disabled:text-ink-300 disabled:hover:bg-transparent"
      :class="size === 'sm' ? 'w-9' : 'w-11'"
      :disabled="modelValue >= max"
      :aria-label="`${label}ni oshirish`"
      @click="set(modelValue + 1)"
    >
      <Plus class="size-4" aria-hidden="true" />
    </button>
  </div>
</template>
