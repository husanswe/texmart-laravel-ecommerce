<script setup lang="ts">
import { CreditCard, ShieldCheck, Store, Truck } from '@lucide/vue'

useSeoMeta({
  title: 'Maishiy texnika va elektronika',
  description:
    "Texmart — smartfonlar, noutbuklar, televizorlar, sovutgichlar va maishiy texnika. Muddatli to'lov 24 oygacha, O'zbekiston bo'ylab yetkazib berish.",
})

const { data: categories } = await useAsyncData('home-categories', () => listCategories(), {
  default: () => [],
})

const TRUST = [
  { icon: ShieldCheck, title: 'Rasmiy kafolat', body: 'Barcha mahsulotlarga ishlab chiqaruvchi kafolati' },
  { icon: Truck, title: 'Tez yetkazib berish', body: "O'zbekiston bo'ylab 1–3 kun ichida" },
  { icon: CreditCard, title: "Muddatli to'lov", body: "24 oygacha, boshlang'ich to'lovsiz" },
  { icon: Store, title: '30 ta do‘kon', body: 'Buyurtmani do‘kondan olib ketish mumkin' },
]
</script>

<template>
  <div class="container-page py-6 md:py-8">
    <!-- The page needs a first-level heading for search engines and screen
         readers. It is visually hidden rather than rendered as a hero, because
         the home page leads with the category grid by design. -->
    <h1 class="sr-only">Texmart — maishiy texnika va elektronika onlayn do'koni</h1>

    <!-- ── Category grid ────────────────────────────────────────────────── -->
    <section>
      <div class="mb-4 flex items-baseline justify-between gap-4">
        <h2 class="text-h2-m md:text-h2">Kategoriyalar</h2>
        <NuxtLink
          to="/catalog"
          class="shrink-0 text-small font-semibold text-brand-700 transition-colors hover:text-brand-500"
        >
          Hammasini ko‘rish →
        </NuxtLink>
      </div>

      <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
        <CategoryTile v-for="category in categories" :key="category.id" :category="category" />
      </div>
    </section>

    <!-- ── Trust row ────────────────────────────────────────────────────── -->
    <section class="mt-10 md:mt-14">
      <ul
        class="grid gap-px overflow-hidden rounded-lg border border-line bg-line sm:grid-cols-2 lg:grid-cols-4"
      >
        <li v-for="item in TRUST" :key="item.title" class="flex gap-3 bg-surface p-5">
          <component :is="item.icon" class="size-6 shrink-0 text-brand-500" aria-hidden="true" />
          <div class="min-w-0">
            <h3 class="text-h3-m md:text-h3">{{ item.title }}</h3>
            <p class="mt-0.5 text-small text-ink-500">{{ item.body }}</p>
          </div>
        </li>
      </ul>
    </section>
  </div>
</template>
