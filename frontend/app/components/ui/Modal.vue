<script setup lang="ts">
import { X } from '@lucide/vue'

const props = withDefaults(
  defineProps<{
    modelValue: boolean
    title?: string
    /** Panel width. `lg` is used by the image lightbox. */
    size?: 'sm' | 'md' | 'lg'
  }>(),
  { title: undefined, size: 'md' },
)

const emit = defineEmits<{ 'update:modelValue': [value: boolean] }>()

const isOpen = computed(() => props.modelValue)
const panel = ref<HTMLElement | null>(null)
const titleId = useId()

function close() {
  emit('update:modelValue', false)
}

useOverlay(isOpen, panel, close)

const SIZE_CLASS = { sm: 'max-w-md', md: 'max-w-xl', lg: 'max-w-4xl' } as const
</script>

<template>
  <ClientOnly>
    <Teleport to="body">
      <div v-if="modelValue" class="fixed inset-0 z-50 flex items-end justify-center sm:items-center">
        <div
          class="absolute inset-0 bg-ink-900/40"
          aria-hidden="true"
          @click="close"
        />

        <div
          ref="panel"
          role="dialog"
          aria-modal="true"
          :aria-labelledby="title ? titleId : undefined"
          tabindex="-1"
          class="relative m-0 w-full rounded-t-lg border border-line bg-surface shadow-float outline-none sm:m-4 sm:rounded-lg"
          :class="SIZE_CLASS[size]"
        >
          <header
            v-if="title || $slots.header"
            class="flex items-start justify-between gap-4 border-b border-line px-5 py-4"
          >
            <h2 :id="titleId" class="text-h3-m md:text-h3">
              <slot name="header">{{ title }}</slot>
            </h2>
            <button
              type="button"
              class="-mr-1.5 -mt-1 grid size-9 shrink-0 place-items-center rounded-md text-ink-500 transition-colors hover:bg-canvas hover:text-ink-900"
              aria-label="Yopish"
              @click="close"
            >
              <X class="size-5" aria-hidden="true" />
            </button>
          </header>

          <div class="max-h-[70vh] overflow-y-auto px-5 py-4">
            <slot />
          </div>

          <footer v-if="$slots.footer" class="border-t border-line px-5 py-4">
            <slot name="footer" />
          </footer>
        </div>
      </div>
    </Teleport>
  </ClientOnly>
</template>
