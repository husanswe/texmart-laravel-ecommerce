<script setup lang="ts">
import { X } from '@lucide/vue'

const props = withDefaults(
  defineProps<{
    modelValue: boolean
    title?: string
    side?: 'left' | 'right'
  }>(),
  { title: undefined, side: 'left' },
)

const emit = defineEmits<{ 'update:modelValue': [value: boolean] }>()

const isOpen = computed(() => props.modelValue)
const panel = ref<HTMLElement | null>(null)
const titleId = useId()

function close() {
  emit('update:modelValue', false)
}

useOverlay(isOpen, panel, close)
</script>

<template>
  <ClientOnly>
    <Teleport to="body">
      <div v-if="modelValue" class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-ink-900/40" aria-hidden="true" @click="close" />

        <div
          ref="panel"
          role="dialog"
          aria-modal="true"
          :aria-labelledby="title ? titleId : undefined"
          tabindex="-1"
          class="absolute inset-y-0 flex w-[86%] max-w-sm flex-col border-line bg-surface shadow-float outline-none"
          :class="side === 'left' ? 'left-0 border-r' : 'right-0 border-l'"
        >
          <header class="flex items-center justify-between gap-4 border-b border-line px-4 py-3.5">
            <h2 :id="titleId" class="text-h3-m md:text-h3">
              <slot name="header">{{ title }}</slot>
            </h2>
            <button
              type="button"
              class="-mr-1.5 grid size-9 shrink-0 place-items-center rounded-md text-ink-500 transition-colors hover:bg-canvas hover:text-ink-900"
              aria-label="Yopish"
              @click="close"
            >
              <X class="size-5" aria-hidden="true" />
            </button>
          </header>

          <div class="flex-1 overflow-y-auto px-4 py-4">
            <slot />
          </div>

          <footer v-if="$slots.footer" class="border-t border-line px-4 py-3.5">
            <slot name="footer" />
          </footer>
        </div>
      </div>
    </Teleport>
  </ClientOnly>
</template>
