<script setup lang="ts">

import { ChevronRight } from '@lucide/vue'
import type { Brand, Category } from '~/types'

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

/** The category whose children fill the middle column. */
const activeId = ref<number | null>(null)

const active = computed(
  () => props.categories.find((c) => c.id === activeId.value) ?? props.categories[0] ?? null,
)

watch(isOpen, (open) => {
  if (open) activeId.value = props.categories[0]?.id ?? null
})

// Brands for the right column. Loaded once, on the client, the first time it's needed.
const { data: brands } = await useAsyncData('mega-menu-brands', () => listBrands(), {
  server: false,
  default: () => [] as Brand[],
})
</script>


<template>
  <ClientOnly>
    <!-- Positioned against the fixed header: drops down right under it, like idea.uz -->
    <div v-if="modelValue" class="absolute inset-x-0 top-full hidden lg:block">
      <!-- Dims the page below the header; the header itself stays bright and clickable. -->
      <div class="absolute inset-x-0 top-0 h-screen bg-ink-900/40" aria-hidden="true" @click="close" />

      <div
        ref="panel"
        class="relative border-t border-line bg-surface shadow-float outline-none"
        role="dialog"
        aria-modal="true"
        aria-label="Mahsulotlar katalogi"
        tabindex="-1"
      >
        <div class="container-page grid h-[min(560px,calc(100vh-180px))] grid-cols-[300px_1fr_280px] py-4">
          <!-- Left: top-level categories -->
          <ul class="min-h-0 overflow-y-auto border-r border-line pr-3">
            <li v-for="category in categories" :key="category.id">
              <NuxtLink
                :to="`/c/${category.slug}`"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-body transition-colors"
                :class="
                  active?.id === category.id
                    ? 'bg-brand-50 font-medium text-brand-700'
                    : 'text-ink-700 hover:bg-canvas'
                "
                @mouseenter="activeId = category.id"
                @focus="activeId = category.id"
              >
                <CategoryIcon :name="category.icon" class="size-5 shrink-0" />
                <span class="min-w-0 flex-1 truncate">{{ category.name }}</span>
                <ChevronRight class="size-4 shrink-0" aria-hidden="true" />
              </NuxtLink>
            </li>
          </ul>

          <!-- Middle: the highlighted category and its subcategories -->
          <div v-if="active" class="min-h-0 overflow-y-auto px-8">
            <h2 class="text-display-m text-ink-900">{{ active.name }}</h2>

            <NuxtLink
              :to="`/c/${active.slug}`"
              class="mt-5 block text-body font-semibold text-ink-900 transition-colors hover:text-brand-700"
            >
              Barcha {{ active.name.toLowerCase() }}
              <span class="font-normal text-ink-300 tnum">({{ active.products_count ?? 0 }})</span>
            </NuxtLink>

            <ul v-if="active.children?.length" class="mt-3 space-y-1">
              <li v-for="child in active.children" :key="child.id">
                <NuxtLink
                  :to="`/c/${child.slug}`"
                  class="block py-1.5 text-body text-ink-500 transition-colors hover:text-brand-700"
                >
                  {{ child.name }}
                </NuxtLink>
              </li>
            </ul>
            <p v-else class="mt-3 text-small text-ink-300">Bu kategoriyada bo'limlar yo'q.</p>
          </div>

          <!-- Right: brands -->
          <div class="min-h-0 overflow-y-auto border-l border-line pl-6">
            <p class="mb-3 text-small font-medium text-ink-500">Brendlar</p>
            <ul class="grid grid-cols-2 gap-3">
              <li
                v-for="brand in brands"
                :key="brand.id"
                class="grid h-20 place-items-center rounded-md bg-canvas px-2 text-center text-h3 font-bold uppercase tracking-wide text-ink-300"
              >
                {{ brand.name }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </ClientOnly>
</template>