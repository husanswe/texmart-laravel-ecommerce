<script setup lang="ts">
/** One product tile: image, price, name, plus heart and compare buttons in the top-left corner. */
const props = defineProps<{
  product: {
    id: number
    slug: string
    name: string
    price: number
    images?: { id: number; url: string }[]
    brand?: { name: string } | null
  }
}>()

const image = computed(() => props.product.images?.[0]?.url)
</script>

<template>
  <div class="relative flex flex-col rounded-lg border border-line bg-surface p-3 transition-colors hover:border-brand-300">
    <!-- Outside the NuxtLink, so clicking a button never opens the product page -->
    <ProductActions :product-id="product.id" class="absolute left-2 top-2 z-10" />

    <NuxtLink :to="`/p/${product.slug}`" class="flex flex-1 flex-col">
      <div class="flex aspect-square items-center justify-center overflow-hidden rounded-md bg-white">
        <img
          v-if="image"
          :src="image"
          :alt="product.name"
          loading="lazy"
          class="h-full w-full object-contain"
        />
        <span v-else class="text-small text-ink-300">Rasm yo'q</span>
      </div>

      <p class="mt-3 font-semibold text-ink-900 tnum">{{ formatSum(product.price) }}</p>
      <h3 class="mt-1 line-clamp-2 text-small text-ink-700">{{ product.name }}</h3>
      <p v-if="product.brand" class="mt-1 text-[12px] text-ink-500">Brend: {{ product.brand.name }}</p>
    </NuxtLink>
  </div>
</template>