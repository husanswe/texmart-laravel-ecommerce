<script setup lang="ts">

    import { ChevronLeft, ChevronRight } from '@lucide/vue'
    const cart = useCartStore()
    const route = useRoute()
    const productSlug = computed(() => route.params.slug as string)

    const { data: rawData, pending, error } = await useAsyncData(
      `product-detail-${productSlug.value}`,
      () => useApi(`/products/${productSlug.value}`),
      { watch: [productSlug] }
    )

    const product = computed(() => {
      const val = unref(rawData)
      return (val as any)?.data ?? val
    })

    const selectedImageIndex = ref(0)

    
    // ── Image gallery: arrows, keyboard and swipe ──
    const imageCount = computed(() => product.value?.images?.length ?? 0)

    function nextImage() {
      if (imageCount.value < 2) return
      selectedImageIndex.value = (selectedImageIndex.value + 1) % imageCount.value
    }

    function prevImage() {
      if (imageCount.value < 2) return
      selectedImageIndex.value = (selectedImageIndex.value - 1 + imageCount.value) % imageCount.value
    }

    // Swipe on phones: a horizontal drag of more than 40px changes the image.
    let touchStartX = 0
    function onTouchStart(e: TouchEvent) {
      touchStartX = e.touches[0]?.clientX ?? 0
    }
    function onTouchEnd(e: TouchEvent) {
      const delta = (e.changedTouches[0]?.clientX ?? 0) - touchStartX
      if (delta > 40) prevImage()
      if (delta < -40) nextImage()
    }

    // Opening another product starts from its first image.
    watch(productSlug, () => {
      selectedImageIndex.value = 0
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
      <!-- Image Gallery -->
      <div class="flex flex-col gap-4">
        <div
          class="group relative aspect-square flex items-center justify-center overflow-hidden rounded-lg border border-line bg-canvas p-4 outline-none focus-visible:ring-2 focus-visible:ring-brand-500"
          tabindex="0"
          aria-roledescription="carousel"
          @keydown.right.prevent="nextImage"
          @keydown.left.prevent="prevImage"
          @touchstart.passive="onTouchStart"
          @touchend="onTouchEnd"
        >
          <img
            v-if="product.images && product.images.length > 0"
            :src="product.images[selectedImageIndex]?.url"
            :alt="product.name"
            class="h-full w-full object-contain"
          />
          <span v-else class="text-ink-500">Mahsulot rasmi yo'q</span>
        </div>

        <div v-if="product.images && product.images.length > 1" class="flex gap-3 overflow-x-auto pb-2">
            <button
                v-for="(img, idx) in product.images"
                :key="idx"
                @click="selectedImageIndex = Number(idx)"
                class="h-20 w-20 shrink-0 overflow-hidden rounded-md border p-1 transition"
                :class="selectedImageIndex === Number(idx) ? 'border-brand-600 ring-2 ring-brand-600/20' : 'border-line opacity-70 hover:opacity-100'"
            >
                <img
                :src="img.url"
                :alt="product.name + ' ' + (Number(idx) + 1)"
                class="h-full w-full object-contain"
                />
            </button>
        </div>
      </div>

      <!-- Product Info -->
      <div class="flex flex-col justify-between">
        <div>
          <h1 class="text-h2 mb-4 text-ink-900">{{ product.name }}</h1>
          <p class="text-h3 mb-6 font-semibold text-brand-600">{{ formatSum(product.price) }}</p>
          <p v-if="product.description" class="mb-6 text-ink-500">{{ product.description }}</p>
        </div>

        <button
          @click="cart.addToServer(product.productVariant[0].id, product.id)"
          class="btn-press w-full rounded-lg bg-brand-600 py-3 font-medium text-white transition hover:bg-brand-700 sm:w-auto sm:px-6"
        >
          Savatga qo'shish
        </button>
      </div>
    </div>
  </div>
</template>