<script setup lang="ts">
import { ChevronDown } from '@lucide/vue'

const props = withDefaults(
  defineProps<{
    title: string
    /** Filter groups open by default; PDP sections on mobile do not. */
    open?: boolean
    count?: number
  }>(),
  { open: true, count: undefined },
)

const isOpen = ref(props.open)
const contentId = useId()
</script>

<template>
  <div class="border-b border-line last:border-b-0">
    <h3>
      <button
        type="button"
        class="flex w-full items-center justify-between gap-3 py-3.5 text-left transition-colors hover:text-brand-700"
        :aria-expanded="isOpen"
        :aria-controls="contentId"
        @click="isOpen = !isOpen"
      >
        <span class="text-h3-m text-ink-900 md:text-h3">
          {{ title }}
          <span v-if="count !== undefined" class="ml-1 text-small text-ink-300 tnum">
            {{ count }}
          </span>
        </span>
        <ChevronDown
          class="size-4 shrink-0 text-ink-500 transition-transform"
          :class="isOpen && 'rotate-180'"
          aria-hidden="true"
        />
      </button>
    </h3>
    <div v-show="isOpen" :id="contentId" class="pb-4">
      <slot />
    </div>
  </div>
</template>
