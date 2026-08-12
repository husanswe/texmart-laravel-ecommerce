<script setup lang="ts">
import { X } from '@lucide/vue'

const props = withDefaults(
  defineProps<{
    modelValue: boolean
    title?: string
  }>(),
  { title: undefined },
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
      <div v-if="modelValue" class="fixed inset-0 z-50 flex flex-col justify-end">
        <div class="absolute inset-0 bg-ink-900/40" aria-hidden="true" @click="close" />

        <!-- Full height minus a peek of the page, so it reads as a sheet over
             the results rather than a second page. -->
        <div
          ref="panel"
          role="dialog"
          aria-modal="true"
          :aria-labelledby="title ? titleId : undefined"
          tabindex="-1"
          class="relative flex max-h-[88vh] flex-col rounded-t-lg border-t border-line bg-surface shadow-float outline-none"
          style="padding-bottom: env(safe-area-inset-bottom)"
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
