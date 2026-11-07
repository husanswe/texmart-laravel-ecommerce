<script setup lang="ts">
  const cart = useCartStore()

  const { data: rawData, pending, error, refresh } = await useAsyncData(
    'cart-page',
    () => useApi('/cart', { headers: { 'X-Cart-Token': String(localStorage.getItem('cart_token') ?? '') ?? '' } }),
    { server: false }
  )


  const serverCart = computed(() => {
    const val = unref(rawData)
    return (val as any)?.data ?? val
  })

  
  const items = computed(() => serverCart.value?.cart_items ?? serverCart.value?.cartItems ?? [])

  async function remove(itemId: number) {
    await useApi(`/cart/items/${itemId}`, {
      method: 'DELETE',
      headers: { 'X-Cart-Token': String(localStorage.getItem('cart_token') ?? '') },
    })
    await refresh()
  }
</script>

<template>
  <div class="container-page py-6 md:py-8">
    <h1 class="text-h2 mb-6">Savat</h1>

    <div v-if="pending" class="py-10 text-center text-ink-500">Yuklanmoqda...</div>
    <div v-else-if="error" class="py-10 text-center text-red-500">Xatolik yuz berdi.</div>

    <div v-else-if="items.length === 0" class="py-10 text-center text-ink-500">
      Savatchangiz bo'sh.
    </div>

    <div v-else class="flex flex-col gap-4">
      <div
        v-for="item in items"
        :key="item.id"
        class="flex items-center justify-between rounded-lg border border-line p-4"
      >
        <div>
          <p class="font-semibold">Variant ID: {{ item.product_variant_id }}</p>
          <p class="text-ink-500">Soni: {{ item.quantity }}</p>
        </div>
        <button @click="remove(item.id)" class="text-red-500 hover:underline">
          O'chirish
        </button>
      </div>
    </div>
  </div>
</template>