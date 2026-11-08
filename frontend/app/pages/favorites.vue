<script setup lang="ts">
import { Heart } from '@lucide/vue'

useSeoMeta({ title: 'Tanlanganlar' })

const favorites = useFavoritesStore()

// Refetch whenever the set of ids changes (first load, login sync, heart clicks).
const idsKey = computed(() => favorites.ids.join(','))

const { data, pending, error } = await useAsyncData(
  'favorites-page',
  () =>
    favorites.ids.length
      ? useApi<any>('/products', { query: { 'ids[]': favorites.ids } })
      : Promise.resolve({ data: [] }),
  { server: false, watch: [idsKey] },
)

// Filter by the store too, so an un-hearted product disappears instantly.
const products = computed<any[]>(() =>
  ((data.value as any)?.data ?? []).filter((p: any) => favorites.has(p.id)),
)
</script>


<template>
  <div class="container-page py-6 md:py-8">
    <div class="mb-6 flex items-baseline justify-between gap-4">
      <h1 class="text-h2">Tanlanganlar</h1>
      <span v-if="favorites.count" class="text-small text-ink-500 tnum">{{ favorites.count }} ta mahsulot</span>
    </div>

    <div v-if="favorites.count === 0" class="flex flex-col items-center py-16 text-center">
      <Heart class="size-12 text-ink-300" aria-hidden="true" />
      <p class="mt-4 text-ink-700">Tanlangan mahsulotlar yo'q.</p>
      <p class="mt-1 text-small text-ink-500">Mahsulot kartasidagi yurakchani bosing.</p>
      <NuxtLink to="/catalog" class="mt-4 font-semibold text-brand-700 hover:text-brand-500">Katalogga o'tish →</NuxtLink>
    </div>

    <div v-else-if="pending && !data" class="py-10 text-center text-ink-500">Yuklanmoqda...</div>
    <div v-else-if="error" class="py-10 text-center text-red-500">Xatolik yuz berdi.</div>

    <div v-else class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:gap-4 lg:grid-cols-4 xl:grid-cols-5">
      <ProductCard v-for="product in products" :key="product.id" :product="product" />
    </div>
  </div>
</template>