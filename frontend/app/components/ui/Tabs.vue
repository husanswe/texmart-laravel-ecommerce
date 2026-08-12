<script setup lang="ts">
export interface TabItem {
  value: string
  label: string
}

const props = withDefaults(
  defineProps<{
    modelValue: string
    items: TabItem[]
    /** `line` for page-level tabs, `segment` for the installment month picker. */
    variant?: 'line' | 'segment'
    ariaLabel?: string
  }>(),
  { variant: 'line', ariaLabel: undefined },
)

const emit = defineEmits<{ 'update:modelValue': [value: string] }>()

const tablist = ref<HTMLElement | null>(null)

/** Left/right arrows move between tabs, as the tab pattern requires. */
function onKeydown(event: KeyboardEvent) {
  const keys = ['ArrowRight', 'ArrowLeft', 'Home', 'End']
  if (!keys.includes(event.key)) return
  event.preventDefault()

  const index = props.items.findIndex((item) => item.value === props.modelValue)
  const last = props.items.length - 1
  let next = index

  if (event.key === 'ArrowRight') next = index >= last ? 0 : index + 1
  else if (event.key === 'ArrowLeft') next = index <= 0 ? last : index - 1
  else if (event.key === 'Home') next = 0
  else next = last

  const item = props.items[next]
  if (!item) return
  emit('update:modelValue', item.value)
  nextTick(() => {
    tablist.value?.querySelectorAll<HTMLElement>('[role="tab"]')[next]?.focus()
  })
}
</script>

<template>
  <div
    ref="tablist"
    role="tablist"
    :aria-label="ariaLabel"
    class="flex"
    :class="
      variant === 'line'
        ? 'gap-6 overflow-x-auto border-b border-line'
        : 'gap-1 rounded-md border border-line bg-canvas p-1'
    "
    @keydown="onKeydown"
  >
    <button
      v-for="item in items"
      :key="item.value"
      type="button"
      role="tab"
      :aria-selected="modelValue === item.value"
      :tabindex="modelValue === item.value ? 0 : -1"
      class="shrink-0 whitespace-nowrap transition-colors"
      :class="[
        variant === 'line'
          ? 'border-b-2 pb-3 text-body font-semibold'
          : 'h-9 flex-1 rounded-sm px-3 text-small font-semibold',
        variant === 'line' && modelValue === item.value
          ? 'border-brand-500 text-ink-900'
          : variant === 'line'
            ? 'border-transparent text-ink-500 hover:text-ink-900'
            : '',
        variant === 'segment' && modelValue === item.value
          ? 'bg-surface text-ink-900 shadow-raise'
          : variant === 'segment'
            ? 'text-ink-500 hover:text-ink-900'
            : '',
      ]"
      @click="$emit('update:modelValue', item.value)"
    >
      {{ item.label }}
    </button>
  </div>
</template>
