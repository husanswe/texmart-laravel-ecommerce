<script setup lang="ts">
import { ChevronRight } from '@lucide/vue'
import type { Category } from '~/types'

const props = defineProps<{
  modelValue: boolean
  categories: Category[]
}>()

const emit = defineEmits<{ 'update:modelValue': [value: boolean] }>()

const isOpen = computed(() => props.modelValue)
const panel = ref<HTMLElement | null>(null)

function close() {
  emit('update:modelValue', false)
}

// Escape, focus trap, focus restore, scroll lock, close-on-navigate.
useOverlay(isOpen, panel, close)

/** The category whose children fill the right-hand area. */
const activeId = ref<number | null>(null)

const active = computed(
  () => props.categories.find((c) => c.id === activeId.value) ?? props.categories[0] ?? null,
)

watch(isOpen, (open) => {
  if (open) activeId.value = props.categories[0]?.id ?? null
})
</script>

<template>
  <ClientOnly>
    <div v-if="modelValue" class="fixed inset-0 top-0 z-40">
      <div class="absolute inset-0 bg-ink-900/40" aria-hidden="true" @click="close" />

      <div
        ref="panel"
        class="relative max-h-[86vh] overflow-y-auto border-b border-line bg-surface shadow-float outline-none"
        role="dialog"
        aria-modal="true"
        aria-label="Mahsulotlar katalogi"
        tabindex="-1"
      >
        <div class="container-page py-5">
          <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
            <!-- Left: top-level categories -->
            <ul class="min-w-0 lg:border-r lg:border-line lg:pr-4">
              <li v-for="category in categories" :key="category.id">
                <NuxtLink
                  :to="`/c/${category.slug}`"
                  class="flex items-center gap-3 rounded-md px-3 py-2.5 text-body transition-colors"
                  :class="
                    active?.id === category.id
                      ? 'bg-brand-50 text-brand-700'
                      : 'text-ink-700 hover:bg-canvas'
                  "
                  @mouseenter="activeId = category.id"
                  @focus="activeId = category.id"
                >
                  <CategoryIcon :name="category.icon" class="size-5 shrink-0" />
                  <span class="min-w-0 flex-1 truncate">{{ category.name }}</span>
                  <span class="shrink-0 text-small text-ink-300 tnum">
                    {{ category.productCount }}
                  </span>
                  <ChevronRight class="size-4 shrink-0 text-ink-300 lg:hidden" aria-hidden="true" />
                </NuxtLink>
              </li>
            </ul>

            <!-- Right: children of the highlighted category, in three columns -->
            <div v-if="active" class="hidden min-w-0 lg:block">
              <div class="mb-3 flex items-baseline justify-between gap-4">
                <h2 class="text-h3">{{ active.name }}</h2>
                <NuxtLink
                  :to="`/c/${active.slug}`"
                  class="text-small text-brand-700 transition-colors hover:text-brand-500"
                >
                  Barchasini ko'rish →
                </NuxtLink>
              </div>

              <ul class="columns-3 gap-6">
                <li v-for="child in active.children" :key="child.id" class="mb-1 break-inside-avoid">
                  <NuxtLink
                    :to="`/c/${child.slug}`"
                    class="flex items-baseline gap-2 rounded-sm px-2 py-1.5 text-body text-ink-700 transition-colors hover:text-brand-700"
                  >
                    <span class="min-w-0 flex-1 truncate">{{ child.name }}</span>
                    <span class="shrink-0 text-small text-ink-300 tnum">
                      {{ child.productCount }}
                    </span>
                  </NuxtLink>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ClientOnly>
</template>
