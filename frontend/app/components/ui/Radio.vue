<script setup lang="ts">
withDefaults(
  defineProps<{
    modelValue?: string
    value: string
    name: string
    label?: string
    /** Secondary line under the label, e.g. a delivery estimate or a fee. */
    description?: string
    disabled?: boolean
  }>(),
  { modelValue: '', label: undefined, description: undefined, disabled: false },
)

defineEmits<{ 'update:modelValue': [value: string] }>()
</script>

<template>
  <label
    class="group flex cursor-pointer items-start gap-2.5 py-1.5 select-none"
    :class="disabled && 'cursor-not-allowed opacity-50'"
  >
    <input
      type="radio"
      :name="name"
      :value="value"
      :checked="modelValue === value"
      :disabled="disabled"
      class="mt-0.5 size-[18px] shrink-0 cursor-pointer appearance-none rounded-full border border-line bg-surface transition-colors checked:border-[5px] checked:border-brand-500 disabled:cursor-not-allowed group-hover:border-brand-300"
      @change="$emit('update:modelValue', value)"
    />
    <span class="min-w-0">
      <span v-if="label" class="block text-body text-ink-900">{{ label }}</span>
      <span v-if="description" class="block text-small text-ink-500">{{ description }}</span>
      <slot />
    </span>
  </label>
</template>
