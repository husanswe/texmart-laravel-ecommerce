<script setup lang="ts">
const route = useRoute()
const productSlug = computed(() => route.params.slug as string)

// Fetch product details from Laravel API endpoint (/api/v1/products/{slug})
const { data: rawData, pending, error } = await useAsyncData(
  `product-detail-${productSlug.value}`,
  () => useApi(`/products/${productSlug.value}`),
  { watch: [productSlug] }
)

const product = computed(() => {
  const val = unref(rawData)
  return (val as any)?.data ?? val
})
</script>

<template>
  <div class="container-page py-6 md:py-8">
    <div v-if="pending" class="py-10 text-center text-ink-500">
      Mahsulot ma'lumotlari yuklanmoqda...
    </div>

    <div v-else-if="error" class="py-10 text-center text-red-500">
      Xatolik yuz berdi: {{ error.message }}
    </div>

    <div v-else-if="product" class="grid grid-cols-1 gap-8 md:grid-cols-2">
      <!-- Product Image Placeholder -->
      <div class="aspect-square flex items-center justify-center rounded-lg border border-line bg-canvas p-4">
        <span class="text-ink-500">Mahsulot rasmi</span>
      </div>

      <!-- Product Details -->
      <div class="flex flex-col justify-between">
        <div>
          <h1 class="text-h2 mb-4 text-ink-900">{{ product.name }}</h1>
          <p class="text-h3 mb-6 font-semibold text-brand-600">{{ product.price }} UZS</p>
          <p v-if="product.description" class="mb-6 text-ink-500">{{ product.description }}</p>
        </div>

        <button class="w-full rounded-lg bg-brand-600 py-3 font-medium text-white transition hover:bg-brand-700 sm:w-auto sm:px-6">
          Savatga qo'shish
        </button>
      </div>
    </div>
  </div>
</template>