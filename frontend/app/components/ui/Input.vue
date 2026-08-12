<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    modelValue?: string | number
    label?: string
    /** Shown under the field in red. Also flips the border and sets aria-invalid. */
    error?: string
    /** Shown under the field in grey when there is no error. */
    hint?: string
    type?: string
    placeholder?: string
    disabled?: boolean
    required?: boolean
    inputmode?: 'text' | 'numeric' | 'tel' | 'email' | 'search' | 'decimal'
    autocomplete?: string
    /** Applies tabular figures — use for any numeric field. */
    numeric?: boolean
  }>(),
  {
    modelValue: '',
    label: undefined,
    error: undefined,
    hint: undefined,
    type: 'text',
    placeholder: undefined,
    disabled: false,
    required: false,
    inputmode: undefined,
    autocomplete: undefined,
    numeric: false,
  },
)

defineEmits<{ 'update:modelValue': [value: string] }>()

const id = useId()
const describedBy = computed(() => {
  if (props.error) return `${id}-error`
  if (props.hint) return `${id}-hint`
  return undefined
})
</script>

<template>
  <div class="w-full">
    <label v-if="label" :for="id" class="mb-1.5 block text-small text-ink-700">
      {{ label }}
      <span v-if="required" class="text-out" aria-hidden="true">*</span>
    </label>

    <div class="relative">
      <span
        v-if="$slots.prefix"
        class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-ink-300"
      >
        <slot name="prefix" />
      </span>

      <input
        :id="id"
        :value="modelValue"
        :type="type"
        :placeholder="placeholder"
        :disabled="disabled"
        :required="required"
        :inputmode="inputmode"
        :autocomplete="autocomplete"
        :aria-invalid="error ? 'true' : undefined"
        :aria-describedby="describedBy"
        class="h-11 w-full rounded-md border bg-surface px-3 text-body text-ink-900 transition-colors outline-none placeholder:text-ink-300 hover:border-ink-300 focus:border-brand-500 disabled:cursor-not-allowed disabled:bg-canvas disabled:text-ink-300"
        :class="[
          error ? 'border-out' : 'border-line',
          numeric && 'tnum',
          $slots.prefix && 'pl-9',
          $slots.suffix && 'pr-9',
        ]"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      />

      <span
        v-if="$slots.suffix"
        class="absolute inset-y-0 right-3 flex items-center text-ink-500"
      >
        <slot name="suffix" />
      </span>
    </div>

    <!-- Field errors live under the field, never in a toast. -->
    <p v-if="error" :id="`${id}-error`" class="mt-1.5 text-small text-out">{{ error }}</p>
    <p v-else-if="hint" :id="`${id}-hint`" class="mt-1.5 text-small text-ink-500">{{ hint }}</p>
  </div>
</template>
