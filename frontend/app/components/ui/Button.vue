<script setup lang="ts">
import { LoaderCircle } from '@lucide/vue'
import { NuxtLink } from '#components'

type Variant = 'primary' | 'secondary' | 'ghost' | 'danger'
type Size = 'sm' | 'md' | 'lg'

const props = withDefaults(
  defineProps<{
    variant?: Variant
    size?: Size
    /** Shows a spinner and blocks interaction without changing the button's width. */
    loading?: boolean
    disabled?: boolean
    /** Full-width, as used at the bottom of a product card. */
    block?: boolean
    type?: 'button' | 'submit' | 'reset'
    /** Renders a NuxtLink instead of a button. */
    to?: string
  }>(),
  {
    variant: 'primary',
    size: 'md',
    loading: false,
    disabled: false,
    block: false,
    type: 'button',
    to: undefined,
  },
)

const VARIANT_CLASS: Record<Variant, string> = {
  primary: 'bg-brand-500 text-white hover:bg-brand-600 active:bg-brand-700',
  secondary:
    'bg-surface text-ink-900 border border-line hover:border-brand-300 hover:text-brand-700 active:bg-brand-50',
  ghost: 'bg-transparent text-ink-700 hover:bg-canvas hover:text-ink-900 active:bg-brand-50',
  danger: 'bg-out text-white hover:brightness-95 active:brightness-90',
}

const SIZE_CLASS: Record<Size, string> = {
  sm: 'h-9 px-3 text-small gap-1.5',
  md: 'h-11 px-4 text-body font-semibold gap-2',
  lg: 'h-12 px-5 text-body font-semibold gap-2',
}

const isInert = computed(() => props.disabled || props.loading)
const tag = computed(() => (props.to && !isInert.value ? NuxtLink : 'button'))
</script>

<template>
  <component
    :is="tag"
    :to="tag === NuxtLink ? to : undefined"
    :type="tag === 'button' ? type : undefined"
    :disabled="tag === 'button' ? isInert : undefined"
    :aria-busy="loading || undefined"
    :aria-disabled="tag !== 'button' && isInert ? 'true' : undefined"
    class="relative inline-flex items-center justify-center rounded-md transition-colors select-none disabled:cursor-not-allowed disabled:bg-canvas disabled:text-ink-300 disabled:border-line disabled:hover:brightness-100"
    :class="[VARIANT_CLASS[variant], SIZE_CLASS[size], block && 'w-full']"
  >
    <!-- The label keeps its box while loading so the button never resizes. -->
    <span class="inline-flex items-center gap-2" :class="loading && 'invisible'">
      <slot name="icon" />
      <slot />
    </span>
    <LoaderCircle v-if="loading" class="absolute size-4 animate-spin" aria-hidden="true" />
  </component>
</template>
