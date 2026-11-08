<script setup lang="ts">
import { Scale, X } from '@lucide/vue'

useSeoMeta({ title: 'Taqqoslash' })

const compare = useCompareStore()
const idsKey = computed(() => compare.ids.join(','))

// The backend requires 2–4 ids, so only call it when there are at least 2.
const { data, pending, error } = await useAsyncData(
  'compare-page',
  () =>
    compare.ids.length >= 2
      ? useApi<any>('/products/compare', { query: { 'ids[]': compare.ids } })
      : Promise.resolve({ data: [] }),
  { server: false, watch: [idsKey] },
)

const products = computed<any[]>(() =>
  ((data.value as any)?.data ?? []).filter((p: any) => compare.has(p.id)),
)

/** Every spec name that appears on at least one product, in first-seen order. */
const specNames = computed<string[]>(() => {
  const names: string[] = []
  for (const p of products.value) {
    for (const a of p.attributes ?? []) {
      if (a.name && !names.includes(a.name)) names.push(a.name)
    }
  }
  return names
})

function specValue(product: any, name: string): string {
  const values = (product.attributes ?? []).filter((a: any) => a.name === name)
  if (!values.length) return '—'
  const unit = values[0].unit ? ` ${values[0].unit}` : ''
  return values.map((v: any) => v.value).join(', ') + unit
}
</script>


<template>
  <div class="container-page py-6 md:py-8">
    <div class="mb-6 flex items-baseline justify-between gap-4">
      <h1 class="text-h2">Taqqoslash</h1>
      <button
        v-if="compare.count"
        type="button"
        class="text-small font-semibold text-brand-700 hover:text-brand-500"
        @click="compare.clear()"
      >
        Hammasini tozalash
      </button>
    </div>

    <div v-if="compare.count < 2" class="flex flex-col items-center py-16 text-center">
      <Scale class="size-12 text-ink-300" aria-hidden="true" />
      <p class="mt-4 text-ink-700">
        {{ compare.count === 0 ? "Taqqoslash ro'yxati bo'sh." : "Yana bitta mahsulot qo'shing." }}
      </p>
      <p class="mt-1 text-small text-ink-500">Taqqoslash uchun 2 tadan 4 tagacha mahsulot tanlang.</p>
      <NuxtLink to="/catalog" class="mt-4 font-semibold text-brand-700 hover:text-brand-500">Katalogga o'tish →</NuxtLink>
    </div>

    <div v-else-if="pending && !data" class="py-10 text-center text-ink-500">Yuklanmoqda...</div>

    <div v-else-if="error" class="py-10 text-center">
      <p class="text-red-500">Mahsulotlarni yuklab bo'lmadi. Ba'zilari o'chirilgan bo'lishi mumkin.</p>
      <button type="button" class="mt-3 font-semibold text-brand-700" @click="compare.clear()">Ro'yxatni tozalash</button>
    </div>

    <!-- Horizontal scroll on phones instead of squeezing 4 columns into 360px -->
    <div v-else class="overflow-x-auto rounded-lg border border-line bg-surface">
      <table class="w-full min-w-160 table-fixed text-small">
        <thead>
          <tr class="border-b border-line align-top">
            <th class="w-40 p-4 text-left font-medium text-ink-500">Mahsulot</th>
            <th v-for="p in products" :key="p.id" class="relative p-4 text-left font-normal">
              <button
                type="button"
                class="absolute right-2 top-2 grid size-7 place-items-center rounded-full text-ink-500 hover:bg-canvas hover:text-red-500"
                aria-label="Taqqoslashdan olib tashlash"
                @click="compare.toggle(p.id)"
              >
                <X class="size-4" />
              </button>
              <NuxtLink :to="`/p/${p.slug}`" class="block">
                <div class="flex aspect-square w-full max-w-36 items-center justify-center overflow-hidden rounded-md bg-white">
                  <img v-if="p.images?.[0]" :src="p.images[0].url" :alt="p.name" class="h-full w-full object-contain" />
                </div>
                <p class="mt-2 font-medium text-ink-900 hover:text-brand-600">{{ p.name }}</p>
              </NuxtLink>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b border-line">
            <td class="p-4 text-ink-500">Narx</td>
            <td v-for="p in products" :key="p.id" class="p-4 font-semibold text-ink-900 tnum">{{ formatSum(p.price) }}</td>
          </tr>
          <tr class="border-b border-line">
            <td class="p-4 text-ink-500">Brend</td>
            <td v-for="p in products" :key="p.id" class="p-4 text-ink-900">{{ p.brand?.name ?? '—' }}</td>
          </tr>
          <tr v-for="name in specNames" :key="name" class="border-b border-line last:border-0">
            <td class="p-4 text-ink-500">{{ name }}</td>
            <td v-for="p in products" :key="p.id" class="p-4 text-ink-900">{{ specValue(p, name) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>