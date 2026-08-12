<script setup lang="ts">
import { Heart, Scale, ShoppingCart, Truck, SearchX, Search } from '@lucide/vue'

useSeoMeta({
  title: 'Styleguide',
  description: 'Texmart design system — tokens and UI primitives.',
  robots: 'noindex, nofollow',
})

const { success, error, info } = useToast()

// ── Live state for the interactive specimens ───────────────────────────────
const text = ref('Samsung Galaxy A55')
const textError = ref('')
const numeric = ref('2399000')
const sortValue = ref('popular')
const checkOne = ref(true)
const checkTwo = ref(false)
const radio = ref('courier')
const qty = ref(1)
const page = ref(3)
const tab = ref('specs')
const months = ref('6')
const chipSelected = ref('256')
const modalOpen = ref(false)
const drawerOpen = ref(false)
const sheetOpen = ref(false)
const loadingDemo = ref(false)

// Class names are written out in full — Tailwind scans source text, so an
// interpolated `bg-${name}` would never be generated.
const COLORS: { group: string; items: { name: string; cls: string }[] }[] = [
  {
    group: 'Brand',
    items: [
      { name: 'brand-50', cls: 'bg-brand-50' },
      { name: 'brand-100', cls: 'bg-brand-100' },
      { name: 'brand-300', cls: 'bg-brand-300' },
      { name: 'brand-500', cls: 'bg-brand-500' },
      { name: 'brand-600', cls: 'bg-brand-600' },
      { name: 'brand-700', cls: 'bg-brand-700' },
    ],
  },
  {
    group: 'Ink',
    items: [
      { name: 'ink-900', cls: 'bg-ink-900' },
      { name: 'ink-700', cls: 'bg-ink-700' },
      { name: 'ink-500', cls: 'bg-ink-500' },
      { name: 'ink-300', cls: 'bg-ink-300' },
    ],
  },
  {
    group: 'Surface',
    items: [
      { name: 'surface', cls: 'bg-surface' },
      { name: 'canvas', cls: 'bg-canvas' },
      { name: 'line', cls: 'bg-line' },
    ],
  },
  {
    group: 'Semantic',
    items: [
      { name: 'stock', cls: 'bg-stock' },
      { name: 'out', cls: 'bg-out' },
      { name: 'install', cls: 'bg-install' },
      { name: 'install-bg', cls: 'bg-install-bg' },
    ],
  },
]

const RADII = [
  { name: 'sm — 6px', cls: 'rounded-sm' },
  { name: 'md — 10px', cls: 'rounded-md' },
  { name: 'lg — 14px', cls: 'rounded-lg' },
]

const SHADOWS = [
  { name: 'raise', cls: 'shadow-raise' },
  { name: 'hover', cls: 'shadow-hover' },
  { name: 'float', cls: 'shadow-float' },
]

const TYPE_SPECIMENS = [
  { name: 'display', cls: 'text-display-m md:text-display', spec: '34/40/700 · mobile 26/32' },
  { name: 'h2', cls: 'text-h2-m md:text-h2', spec: '24/30/650 · mobile 20/26' },
  { name: 'h3', cls: 'text-h3-m md:text-h3', spec: '17/24/600 · mobile 16/22' },
  { name: 'body', cls: 'text-body', spec: '15/24/400' },
  { name: 'small', cls: 'text-small', spec: '13/18/500' },
  { name: 'micro', cls: 'text-micro uppercase', spec: '11/14/600 · +0.04em' },
  { name: 'price', cls: 'text-price-m md:text-price tnum', spec: '20/26/700 · tabular' },
  { name: 'price-lg', cls: 'text-price-lg-m md:text-price-lg tnum', spec: '32/38/700 · tabular' },
]

const SORT_OPTIONS = [
  { value: 'popular', label: 'Ommabop' },
  { value: 'price_asc', label: 'Avval arzonlari' },
  { value: 'price_desc', label: 'Avval qimmatlari' },
  { value: 'newest', label: 'Yangilari' },
]

const TABS = [
  { value: 'specs', label: 'Xususiyatlari' },
  { value: 'about', label: 'Tavsif' },
  { value: 'reviews', label: 'Sharhlar' },
  { value: 'delivery', label: 'Yetkazib berish' },
]

const MONTH_TABS = [
  { value: '6', label: '6 oy' },
  { value: '12', label: '12 oy' },
  { value: '24', label: '24 oy' },
]

// Prices deliberately chosen so the columns show digit alignment doing its job.
const PRICE_ROWS = [
  { name: 'Elektr choynak Tefal KO2708', price: 349_000 },
  { name: 'Redmi A5 3/64 Ocean Blue', price: 1_299_000 },
  { name: 'Samsung Galaxy A55 8/256', price: 4_299_000, oldPrice: 4_999_000 },
  { name: 'LG OLED55C4 55"', price: 12_490_000 },
  { name: 'iPhone 16 Pro Max 512', price: 24_999_000 },
]

function demoLoading() {
  loadingDemo.value = true
  setTimeout(() => (loadingDemo.value = false), 1400)
}
</script>

<template>
  <div class="container-page section-y">
    <header class="mb-10 border-b border-line pb-6">
      <p class="text-micro uppercase text-brand-700">Texmart</p>
      <h1 class="mt-2 text-display-m md:text-display">Styleguide</h1>
      <p class="mt-2 max-w-[68ch] text-body text-ink-500">
        Har bir primitiv — barcha variantlari va holatlari bilan. Sahifalar shu yerdagi
        komponentlardan yig'iladi.
      </p>
    </header>

    <!-- ── Color ───────────────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Ranglar</h2>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div v-for="group in COLORS" :key="group.group">
          <h3 class="mb-2 text-micro uppercase text-ink-500">{{ group.group }}</h3>
          <ul class="overflow-hidden rounded-lg border border-line bg-surface">
            <li
              v-for="item in group.items"
              :key="item.name"
              class="flex items-center gap-3 border-b border-line px-3 py-2 last:border-b-0"
            >
              <span
                class="size-7 shrink-0 rounded-sm border border-line"
                :class="item.cls"
                aria-hidden="true"
              />
              <code class="font-mono text-small text-ink-700">{{ item.name }}</code>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- ── Type ────────────────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Tipografiya</h2>
      <div class="divide-y divide-line rounded-lg border border-line bg-surface">
        <div
          v-for="item in TYPE_SPECIMENS"
          :key="item.name"
          class="flex flex-col gap-1 px-4 py-4 sm:flex-row sm:items-baseline sm:gap-6"
        >
          <div class="w-28 shrink-0">
            <code class="font-mono text-small text-brand-700">{{ item.name }}</code>
            <p class="text-micro uppercase text-ink-300">{{ item.spec }}</p>
          </div>
          <p :class="item.cls" class="min-w-0 text-ink-900">
            Muddatli to'lov 24 oygacha — 1 234 567 so'm
          </p>
        </div>
      </div>

      <div class="mt-4 rounded-lg border border-line bg-surface p-4">
        <h3 class="mb-3 text-h3-m md:text-h3">Tabular figures</h3>
        <p class="mb-3 text-small text-ink-500">
          Chap ustun <code class="font-mono">tnum</code> bilan, o'ng ustun — busiz. Raqamlar
          ustma-ust tushishi kerak.
        </p>
        <div class="grid gap-6 sm:grid-cols-2">
          <ul>
            <li
              v-for="row in PRICE_ROWS"
              :key="row.name"
              class="flex justify-between gap-4 border-b border-line py-1.5 last:border-b-0"
            >
              <span class="truncate text-small text-ink-500">{{ row.name }}</span>
              <span class="shrink-0 text-body font-semibold text-ink-900 tnum">
                {{ formatSum(row.price) }}
              </span>
            </li>
          </ul>
          <ul class="opacity-60">
            <li
              v-for="row in PRICE_ROWS"
              :key="row.name"
              class="flex justify-between gap-4 border-b border-line py-1.5 last:border-b-0"
            >
              <span class="truncate text-small text-ink-500">{{ row.name }}</span>
              <span class="shrink-0 text-body font-semibold text-ink-900">
                {{ formatSum(row.price) }}
              </span>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- ── Radius, shadow, motion ──────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Radius va soya</h2>
      <div class="grid gap-6 sm:grid-cols-2">
        <div class="rounded-lg border border-line bg-surface p-4">
          <h3 class="mb-3 text-h3-m md:text-h3">Radius</h3>
          <div class="flex flex-wrap items-end gap-4">
            <div v-for="r in RADII" :key="r.name" class="text-center">
              <div class="size-16 border border-line bg-canvas" :class="r.cls" aria-hidden="true" />
              <code class="mt-1.5 block font-mono text-small text-ink-500">{{ r.name }}</code>
            </div>
          </div>
        </div>

        <div class="rounded-lg border border-line bg-surface p-4">
          <h3 class="mb-3 text-h3-m md:text-h3">Soya</h3>
          <div class="flex flex-wrap gap-4">
            <div v-for="s in SHADOWS" :key="s.name" class="text-center">
              <div
                class="size-16 rounded-lg border border-line bg-surface"
                :class="s.cls"
                aria-hidden="true"
              />
              <code class="mt-1.5 block font-mono text-small text-ink-500">{{ s.name }}</code>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ── Button ──────────────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Button</h2>
      <div class="space-y-6 rounded-lg border border-line bg-surface p-4 sm:p-6">
        <div v-for="variant in ['primary', 'secondary', 'ghost', 'danger'] as const" :key="variant">
          <h3 class="mb-3 text-micro uppercase text-ink-500">{{ variant }}</h3>
          <div class="flex flex-wrap items-center gap-3">
            <UiButton :variant="variant" size="sm">Savatga</UiButton>
            <UiButton :variant="variant" size="md">Savatga qo'shish</UiButton>
            <UiButton :variant="variant" size="lg">Rasmiylashtirish</UiButton>
            <UiButton :variant="variant" loading>Yuklanmoqda</UiButton>
            <UiButton :variant="variant" disabled>Mavjud emas</UiButton>
            <UiButton :variant="variant">
              <template #icon><ShoppingCart class="size-4" aria-hidden="true" /></template>
              Ikonka bilan
            </UiButton>
          </div>
        </div>

        <div>
          <h3 class="mb-3 text-micro uppercase text-ink-500">Block · link · live loading</h3>
          <div class="grid max-w-md gap-3">
            <UiButton block>To'liq kenglik</UiButton>
            <UiButton to="/styleguide" variant="secondary" block>NuxtLink sifatida</UiButton>
            <UiButton :loading="loadingDemo" block @click="demoLoading">
              Bosing — 1.4 s yuklanadi
            </UiButton>
          </div>
        </div>
      </div>
    </section>

    <!-- ── Form controls ───────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Form elementlari</h2>
      <div class="grid gap-6 rounded-lg border border-line bg-surface p-4 sm:p-6 lg:grid-cols-2">
        <div class="space-y-4">
          <UiInput v-model="text" label="Ism va familiya" placeholder="Husan Sulaymonov" />
          <UiInput
            v-model="text"
            label="Telefon raqami"
            hint="Kirish uchun shu raqam ishlatiladi"
            inputmode="tel"
            numeric
          >
            <template #prefix><span class="text-small">+998</span></template>
          </UiInput>
          <UiInput
            v-model="textError"
            label="E-mail"
            error="E-mail noto'g'ri. Masalan: ism@mail.uz"
            required
          />
          <UiInput v-model="numeric" label="Narx (so'm)" numeric>
            <template #suffix><span class="text-small">so'm</span></template>
          </UiInput>
          <UiInput v-model="text" label="O'chirilgan" disabled />
        </div>

        <div class="space-y-4">
          <UiSelect v-model="sortValue" label="Saralash" :options="SORT_OPTIONS" />
          <UiSelect
            v-model="sortValue"
            label="O'chirilgan"
            :options="SORT_OPTIONS"
            disabled
          />

          <div>
            <h3 class="mb-1.5 text-small text-ink-700">Checkbox</h3>
            <div class="rounded-md border border-line px-3 py-1.5">
              <UiCheckbox v-model="checkOne" label="Samsung" :count="24" />
              <UiCheckbox v-model="checkTwo" label="Xiaomi" :count="18" />
              <UiCheckbox :model-value="false" label="Artel (mavjud emas)" disabled />
            </div>
          </div>

          <div>
            <h3 class="mb-1.5 text-small text-ink-700">Radio</h3>
            <div class="rounded-md border border-line px-3 py-1.5">
              <UiRadio
                v-model="radio"
                name="sg-delivery"
                value="courier"
                label="Kuryer orqali"
                description="1–3 kun · 30 000 so'm"
              />
              <UiRadio
                v-model="radio"
                name="sg-delivery"
                value="pickup"
                label="Do'kondan olib ketish"
                description="Bugundan · bepul"
              />
              <UiRadio
                v-model="radio"
                name="sg-delivery"
                value="post"
                label="Pochta"
                description="Hozircha mavjud emas"
                disabled
              />
            </div>
          </div>

          <div>
            <h3 class="mb-1.5 text-small text-ink-700">QtyStepper</h3>
            <div class="flex items-center gap-3">
              <UiQtyStepper v-model="qty" :max="5" />
              <UiQtyStepper v-model="qty" :max="5" size="sm" />
              <span class="text-small text-ink-500">maks. 5 (ombordagi qoldiq)</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ── Chips & badges ──────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Chip va Badge</h2>
      <div class="space-y-6 rounded-lg border border-line bg-surface p-4 sm:p-6">
        <div>
          <h3 class="mb-3 text-micro uppercase text-ink-500">Badge</h3>
          <div class="flex flex-wrap items-center gap-2">
            <UiBadge tone="discount">-15%</UiBadge>
            <UiBadge tone="out">Sotuvda yo'q</UiBadge>
            <UiBadge tone="stock">Sotuvda bor</UiBadge>
            <UiBadge tone="install">Muddatli to'lov</UiBadge>
            <UiBadge tone="brand">Yangi</UiBadge>
            <UiBadge>Kafolat 12 oy</UiBadge>
          </div>
        </div>

        <div>
          <h3 class="mb-3 text-micro uppercase text-ink-500">Chip — variant tanlash</h3>
          <div class="flex flex-wrap items-center gap-2">
            <UiChip
              v-for="option in ['128', '256', '512']"
              :key="option"
              :selected="chipSelected === option"
              @select="chipSelected = option"
            >
              {{ option }} GB
            </UiChip>
            <UiChip unavailable>1 TB</UiChip>
            <UiChip disabled>O'chirilgan</UiChip>
          </div>
        </div>

        <div>
          <h3 class="mb-3 text-micro uppercase text-ink-500">Chip — faol filtrlar</h3>
          <div class="flex flex-wrap items-center gap-2">
            <UiChip removable selected>Samsung</UiChip>
            <UiChip removable>8 GB</UiChip>
            <UiChip removable>1 000 000 – 5 000 000 so'm</UiChip>
          </div>
        </div>
      </div>
    </section>

    <!-- ── Tabs & accordion ────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Tabs va Accordion</h2>
      <div class="grid gap-6 lg:grid-cols-2">
        <div class="space-y-6 rounded-lg border border-line bg-surface p-4 sm:p-6">
          <div>
            <h3 class="mb-3 text-micro uppercase text-ink-500">Tabs — line</h3>
            <UiTabs v-model="tab" :items="TABS" aria-label="Mahsulot bo'limlari" />
            <p class="pt-4 text-body text-ink-500">Tanlangan: {{ tab }}</p>
          </div>

          <div>
            <h3 class="mb-3 text-micro uppercase text-ink-500">Tabs — segment</h3>
            <div class="max-w-xs rounded-lg border border-install-bg bg-install-bg p-3">
              <UiTabs
                v-model="months"
                :items="MONTH_TABS"
                variant="segment"
                aria-label="Muddatli to'lov muddati"
              />
              <p class="mt-3 text-price-m text-install tnum md:text-price">
                {{ formatSum(installmentFor(4299000, Number(months) as 6 | 12 | 24).monthly) }}
                × {{ months }} oy
              </p>
              <p class="mt-0.5 text-small text-ink-500">
                Jami:
                {{ formatSum(installmentFor(4299000, Number(months) as 6 | 12 | 24).total) }}
              </p>
            </div>
          </div>
        </div>

        <div class="rounded-lg border border-line bg-surface px-4 sm:px-6">
          <UiAccordion title="Brend" :count="14">
            <UiCheckbox :model-value="true" label="Samsung" :count="24" />
            <UiCheckbox :model-value="false" label="LG" :count="19" />
            <UiCheckbox :model-value="false" label="Artel" :count="12" />
          </UiAccordion>
          <UiAccordion title="Operativ xotira (RAM)">
            <UiCheckbox :model-value="false" label="4 GB" :count="8" />
            <UiCheckbox :model-value="false" label="8 GB" :count="12" />
          </UiAccordion>
          <UiAccordion title="Yopiq holat" :open="false">
            <p class="text-body text-ink-500">Ochilganda ko'rinadi.</p>
          </UiAccordion>
        </div>
      </div>
    </section>

    <!-- ── Rating, breadcrumb, pagination ──────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Rating, Breadcrumb, Pagination</h2>
      <div class="space-y-6 rounded-lg border border-line bg-surface p-4 sm:p-6">
        <div class="flex flex-wrap items-center gap-6">
          <UiRating :value="5" :count="128" />
          <UiRating :value="4.3" :count="47" show-value />
          <UiRating :value="2.5" size="md" show-value />
          <UiRating :value="0" :count="0" />
        </div>

        <UiBreadcrumb
          :items="[
            { label: 'Bosh sahifa', to: '/' },
            { label: 'Smartfonlar va telefonlar', to: '/styleguide' },
            { label: 'Samsung Galaxy A55 8/256' },
          ]"
        />

        <UiPagination :page="page" :total-pages="12" @update:page="page = $event" />
      </div>
    </section>

    <!-- ── Skeleton & empty ────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Skeleton va EmptyState</h2>
      <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border border-line bg-surface p-4">
          <h3 class="mb-3 text-micro uppercase text-ink-500">Skeleton — karta o'lchamlari</h3>
          <div class="max-w-[264px] rounded-lg border border-line p-4">
            <UiSkeleton class="aspect-square w-full" rounded="md" />
            <UiSkeleton class="mt-4 h-4 w-full" />
            <UiSkeleton class="mt-2 h-4 w-2/3" />
            <UiSkeleton class="mt-4 h-6 w-1/2" />
            <UiSkeleton class="mt-2 h-4 w-3/5" />
            <UiSkeleton class="mt-4 h-11 w-full" rounded="md" />
          </div>
        </div>

        <UiEmptyState
          :icon="SearchX"
          title="Ushbu filtrlar bo'yicha mahsulot topilmadi"
          description="Narx oralig'ini kengaytiring yoki brend filtrini olib tashlang."
        >
          <UiButton variant="secondary">Brend filtrini tozalash</UiButton>
          <UiButton>Hammasini tozalash</UiButton>
        </UiEmptyState>
      </div>
    </section>

    <!-- ── Overlays & toast ────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Overlaylar va Toast</h2>
      <div class="rounded-lg border border-line bg-surface p-4 sm:p-6">
        <p class="mb-4 max-w-[68ch] text-small text-ink-500">
          Har biri <kbd class="rounded-sm border border-line px-1 font-mono text-micro">Esc</kbd>
          bilan yopiladi, fokusni ichida ushlab turadi va yopilganda fokusni tugmaga qaytaradi.
        </p>
        <div class="flex flex-wrap gap-3">
          <UiButton variant="secondary" @click="modalOpen = true">Modal</UiButton>
          <UiButton variant="secondary" @click="drawerOpen = true">Drawer</UiButton>
          <UiButton variant="secondary" @click="sheetOpen = true">BottomSheet</UiButton>
          <UiButton variant="secondary" @click="success('Mahsulot savatga qo\'shildi')">
            Toast — success
          </UiButton>
          <UiButton variant="secondary" @click="error('Taqqoslashga 4 tadan ko\'p qo\'sha olmaysiz')">
            Toast — error
          </UiButton>
          <UiButton variant="secondary" @click="info('Sevimlilardan olib tashlandi')">
            Toast — info
          </UiButton>
        </div>
      </div>
    </section>

    <!-- ── Icon buttons ────────────────────────────────────────────────── -->
    <section class="mb-12">
      <h2 class="mb-4 text-h2-m md:text-h2">Ikonka tugmalari</h2>
      <div class="flex flex-wrap items-center gap-3 rounded-lg border border-line bg-surface p-4 sm:p-6">
        <button
          type="button"
          class="grid size-9 place-items-center rounded-md border border-line bg-surface text-ink-300 transition-colors hover:border-brand-300 hover:text-brand-500"
          aria-label="Sevimlilarga qo'shish"
          :aria-pressed="false"
        >
          <Heart class="size-4.5" aria-hidden="true" />
        </button>
        <button
          type="button"
          class="grid size-9 place-items-center rounded-md border border-out bg-surface text-out transition-colors"
          aria-label="Sevimlilardan olib tashlash"
          :aria-pressed="true"
        >
          <Heart class="size-4.5 fill-out" aria-hidden="true" />
        </button>
        <button
          type="button"
          class="grid size-9 place-items-center rounded-md border border-line bg-surface text-ink-300 transition-colors hover:border-brand-300 hover:text-brand-500"
          aria-label="Taqqoslashga qo'shish"
          :aria-pressed="false"
        >
          <Scale class="size-4.5" aria-hidden="true" />
        </button>
        <button
          type="button"
          class="grid size-9 place-items-center rounded-md border border-brand-500 bg-brand-50 text-brand-600 transition-colors"
          aria-label="Taqqoslashdan olib tashlash"
          :aria-pressed="true"
        >
          <Scale class="size-4.5" aria-hidden="true" />
        </button>
        <span class="text-small text-ink-500">
          36px · <code class="font-mono">aria-pressed</code> · faol holatda to'ldirilgan
        </span>
      </div>
    </section>

    <UiModal v-model="modalOpen" title="Rasmni ko'rish">
      <p class="text-body text-ink-700">
        Modal ichidagi fokus tuzoqqa olinadi. <kbd class="font-mono text-micro">Tab</kbd> paneldan
        chiqmaydi.
      </p>
      <UiInput v-model="text" class="mt-4" label="Sinov maydoni" />
      <template #footer>
        <div class="flex justify-end gap-3">
          <UiButton variant="ghost" @click="modalOpen = false">Bekor qilish</UiButton>
          <UiButton @click="modalOpen = false">Tasdiqlash</UiButton>
        </div>
      </template>
    </UiModal>

    <UiDrawer v-model="drawerOpen" title="Mahsulotlar katalogi">
      <ul class="space-y-1">
        <li v-for="c in ['Smartfonlar', 'Noutbuklar', 'Televizorlar', 'Sovutgichlar']" :key="c">
          <a href="#" class="block rounded-md px-3 py-2.5 text-body text-ink-700 hover:bg-canvas">
            {{ c }}
          </a>
        </li>
      </ul>
    </UiDrawer>

    <UiBottomSheet v-model="sheetOpen" title="Filtrlar">
      <UiAccordion title="Brend">
        <UiCheckbox :model-value="true" label="Samsung" :count="24" />
        <UiCheckbox :model-value="false" label="LG" :count="19" />
      </UiAccordion>
      <template #footer>
        <div class="flex gap-3">
          <UiButton variant="secondary" block @click="sheetOpen = false">Tozalash</UiButton>
          <UiButton block @click="sheetOpen = false">Ko'rsatish</UiButton>
        </div>
      </template>
    </UiBottomSheet>

    <p class="mt-10 flex items-center gap-2 border-t border-line pt-6 text-small text-ink-500">
      <Truck class="size-4" aria-hidden="true" />
      Bu sahifa faqat ichki foydalanish uchun — indekslanmaydi.
      <Search class="ml-auto size-4" aria-hidden="true" />
    </p>
  </div>
</template>
