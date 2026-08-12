<script setup lang="ts">
import { ChevronLeft, ChevronRight } from '@lucide/vue'

const props = defineProps<{
  page: number
  totalPages: number
}>()

defineEmits<{ 'update:page': [page: number] }>()

/**
 * First, last, current and its neighbours, with `null` marking an elision.
 * Keeps the control a fixed width however many pages there are.
 */
const pages = computed<(number | null)[]>(() => {
  const { page, totalPages } = props
  if (totalPages <= 7) return Array.from({ length: totalPages }, (_, i) => i + 1)

  const out: (number | null)[] = [1]
  const from = Math.max(2, page - 1)
  const to = Math.min(totalPages - 1, page + 1)

  if (from > 2) out.push(null)
  for (let i = from; i <= to; i++) out.push(i)
  if (to < totalPages - 1) out.push(null)
  out.push(totalPages)

  return out
})
</script>

<template>
  <nav v-if="totalPages > 1" aria-label="Sahifalar" class="flex items-center justify-center gap-1">
    <button
      type="button"
      class="grid size-10 place-items-center rounded-md border border-line bg-surface text-ink-700 transition-colors hover:border-brand-300 hover:text-brand-700 disabled:cursor-not-allowed disabled:text-ink-300 disabled:hover:border-line"
      :disabled="page <= 1"
      aria-label="Oldingi sahifa"
      @click="$emit('update:page', page - 1)"
    >
      <ChevronLeft class="size-4" aria-hidden="true" />
    </button>

    <template v-for="(item, i) in pages" :key="i">
      <span v-if="item === null" class="grid size-10 place-items-center text-ink-300">…</span>
      <button
        v-else
        type="button"
        class="grid size-10 place-items-center rounded-md border text-body font-semibold transition-colors tnum"
        :class="
          item === page
            ? 'border-brand-500 bg-brand-500 text-white'
            : 'border-line bg-surface text-ink-700 hover:border-brand-300 hover:text-brand-700'
        "
        :aria-current="item === page ? 'page' : undefined"
        @click="$emit('update:page', item)"
      >
        {{ item }}
      </button>
    </template>

    <button
      type="button"
      class="grid size-10 place-items-center rounded-md border border-line bg-surface text-ink-700 transition-colors hover:border-brand-300 hover:text-brand-700 disabled:cursor-not-allowed disabled:text-ink-300 disabled:hover:border-line"
      :disabled="page >= totalPages"
      aria-label="Keyingi sahifa"
      @click="$emit('update:page', page + 1)"
    >
      <ChevronRight class="size-4" aria-hidden="true" />
    </button>
  </nav>
</template>
