<script setup lang="ts">

import { ChevronLeft, ChevronRight } from '@lucide/vue'
import type { Category } from '~/types'

useSeoMeta({ title: 'Katalog' })

const route = useRoute()
const router = useRouter()

// Page and sort live in the URL (?page=2&sort=price_asc), so a link or a refresh keeps them.
const page = computed(() => Math.max(1, Number(route.query.page) || 1))
const sort = computed(() => (route.query.sort as string) || 'latest')

const SORTS = [
  { value: 'latest', label: 'Yangilari' },
  { value: 'price_asc', label: 'Avval arzonlari' },
  { value: 'price_desc', label: 'Avval qimmatlari' },
]

// Categories: GET /categories returns { data: [...] }
const { data: rawCategories } = await useAsyncData('catalog-categories', () => useApi<any>('/categories'))
const categories = computed<Category[]>(() => (rawCategories.value as any)?.data ?? [])

// Products: GET /products?page=1&sort=latest — a Laravel paginated resource { data, meta }
const { data: rawProducts, pending, error } = await useAsyncData(
  'catalog-products',
  () => useApi<any>('/products', { query: { page: page.value, sort: sort.value } }),
  { watch: [page, sort] },
)
const products = computed<any[]>(() => (rawProducts.value as any)?.data ?? [])
const meta = computed(() => (rawProducts.value as any)?.meta ?? { current_page: 1, last_page: 1, total: 0 })

function setQuery(next: Record<string, string | number | undefined>) {
  router.push({ query: { ...route.query, ...next } })
  if (import.meta.client) window.scrollTo({ top: 0, behavior: 'smooth' })
}
</script>


<template>
  <div class="container-page py-6 md:py-8">
    <h1 class="sr-only">Katalog</h1>

    <!-- Categories -->
    <section>
      <h2 class="mb-4 text-h2-m md:text-h2">Kategoriyalar</h2>
      <div class="grid grid-cols-2 gap-3 md:grid-cols-3 md:gap-4 lg:grid-cols-4">
        <CategoryTile v-for="category in categories" :key="category.id" :category="category" />
      </div>
    </section>

    <!-- All products -->
    <section class="mt-10 md:mt-14">
      <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-h2-m md:text-h2">
          Barcha mahsulotlar
          <span class="text-small font-normal text-ink-500 tnum">({{ meta.total }})</span>
        </h2>

        <label class="flex items-center gap-2 text-small text-ink-500">
          Saralash:
          <select
            :value="sort"
            class="h-10 rounded-md border border-line bg-white px-3 text-ink-900 outline-none focus:border-brand-500"
            @change="setQuery({ sort: ($event.target as HTMLSelectElement).value, page: undefined })"
          >
            <option v-for="s in SORTS" :key="s.value" :value="s.value">{{ s.label }}</option>
          </select>
        </label>
      </div>

      <div v-if="pending && !rawProducts" class="py-10 text-center text-ink-500">Yuklanmoqda...</div>
      <div v-else-if="error" class="py-10 text-center text-red-500">Xatolik yuz berdi.</div>
      <div v-else-if="products.length === 0" class="py-10 text-center text-ink-500">Mahsulotlar topilmadi.</div>

      <template v-else>
        <div
          class="grid grid-cols-2 gap-3 transition-opacity sm:grid-cols-3 md:gap-4 lg:grid-cols-4 xl:grid-cols-5"
          :class="pending && 'opacity-60'"
        >
          <ProductCard v-for="product in products" :key="product.id" :product="product" />
        </div>

        <!-- Pagination -->
        <nav v-if="meta.last_page > 1" class="mt-8 flex items-center justify-center gap-2" aria-label="Sahifalar">
          <button
            type="button"
            class="grid size-10 place-items-center rounded-md border border-line bg-white text-ink-700 hover:border-brand-300 disabled:opacity-40"
            :disabled="page <= 1"
            aria-label="Oldingi sahifa"
            @click="setQuery({ page: page - 1 })"
          >
            <ChevronLeft class="size-5" />
          </button>

          <button
            v-for="n in meta.last_page"
            :key="n"
            type="button"
            class="grid size-10 place-items-center rounded-md border text-small font-semibold tnum"
            :class="n === page ? 'border-brand-600 bg-brand-600 text-white' : 'border-line bg-white text-ink-700 hover:border-brand-300'"
            :aria-current="n === page ? 'page' : undefined"
            @click="setQuery({ page: n })"
          >
            {{ n }}
          </button>

          <button
            type="button"
            class="grid size-10 place-items-center rounded-md border border-line bg-white text-ink-700 hover:border-brand-300 disabled:opacity-40"
            :disabled="page >= meta.last_page"
            aria-label="Keyingi sahifa"
            @click="setQuery({ page: page + 1 })"
          >
            <ChevronRight class="size-5" />
          </button>
        </nav>
      </template>
    </section>
  </div>
</template>