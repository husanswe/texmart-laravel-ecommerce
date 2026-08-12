<script setup lang="ts">
import { CircleCheck, CircleAlert, Info, X } from '@lucide/vue'
import type { ToastTone } from '~/composables/useToast'

withDefaults(defineProps<{ tone?: ToastTone; message: string }>(), { tone: 'success' })

defineEmits<{ dismiss: [] }>()

const ICON = { success: CircleCheck, error: CircleAlert, info: Info }
const TONE_CLASS: Record<ToastTone, string> = {
  success: 'text-stock',
  error: 'text-out',
  info: 'text-brand-500',
}
</script>

<template>
  <div
    class="pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-lg border border-line bg-surface px-4 py-3 shadow-float"
    role="status"
  >
    <component :is="ICON[tone]" class="mt-0.5 size-5 shrink-0" :class="TONE_CLASS[tone]" aria-hidden="true" />
    <p class="min-w-0 flex-1 text-body text-ink-900">{{ message }}</p>
    <button
      type="button"
      class="-mr-1.5 -mt-0.5 grid size-7 shrink-0 place-items-center rounded-sm text-ink-500 transition-colors hover:bg-canvas hover:text-ink-900"
      aria-label="Yopish"
      @click="$emit('dismiss')"
    >
      <X class="size-4" aria-hidden="true" />
    </button>
  </div>
</template>
