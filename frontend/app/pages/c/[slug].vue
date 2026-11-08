<script setup lang="ts">
  const route = useRoute()

  // Computed category slug to enforce reactivity
  const categorySlug = computed(() => route.params.slug as string)

  // Fetch products dynamically with route parameter watching enabled
  const { data: rawData, pending, error } = await useAsyncData(
    `category-products-${categorySlug.value}`,
    () => useApi('/products', { query: { category: categorySlug.value } }),
    { watch: [categorySlug] }
  )

  const products = computed(() => {
    const val = unref(rawData)
    return Array.isArray(val) ? val : (val as any)?.data ?? []
  })
</script>

<template>
  <div class="container-page py-6 md:py-8">
    <h1 class="text-h2 mb-6 capitalize">{{ categorySlug }}</h1>

    <div v-if="pending" class="py-10 text-center text-ink-500">
      Mahsulotlar yuklanmoqda...
    </div>

    <div v-else-if="error" class="py-10 text-center text-red-500">
      Xatolik yuz berdi: {{ error.message }}
    </div>

    <div v-else-if="products.length === 0" class="py-10 text-center text-ink-500">
      Ushbu kategoriyada mahsulotlar topilmadi.
    </div>

    <div v-else class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:gap-4 lg:grid-cols-4 xl:grid-cols-5">
      <ProductCard v-for="product in products" :key="product.id" :product="product" />
    </div>
  </div>
</template>