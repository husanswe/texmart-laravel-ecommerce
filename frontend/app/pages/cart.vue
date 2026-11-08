<script setup lang="ts">
import { Minus, Plus, Trash2 } from '@lucide/vue'

const cart = useCartStore()
const headers = () => ({ 'X-Cart-Token': localStorage.getItem('cart_token') ?? '' })

const { data, pending, error, refresh } = await useAsyncData(
  'cart-page',
  async () => {
    const res: any = await useApi('/cart', { headers: headers() })
    if (res?.cart_token) localStorage.setItem('cart_token', res.cart_token)
    return res
  },
  { server: false },
)

const items = computed<any[]>(() => (unref(data) as any)?.items ?? [])
const total = computed<number>(() => (unref(data) as any)?.total ?? 0)

// keep the header badge in sync with the server cart
watch(data, (val: any) => {
  if (!val) return
  cart.hydrate(
    (val.items ?? []).map((i: any) => ({ productId: i.product_id, variantId: i.variant_id, qty: i.quantity })),
  )
})

const qtyError = ref('')

async function changeQty(item: any, qty: number) {
  qtyError.value = ''
  if (qty < 1) return
  // Block only increases past stock; decreasing is always allowed.
  if (qty > item.quantity && qty > item.stock) return
  try {
    await useApi(`/cart/items/${item.id}`, { method: 'PUT', headers: headers(), body: { quantity: qty } })
  } catch (e) {
    qtyError.value = apiErrorMessage(e)
  }
  await refresh()
}

async function remove(item: any) {
  await useApi(`/cart/items/${item.id}`, { method: 'DELETE', headers: headers() })
  await refresh()
}
</script>


<template>
  <div class="container-page py-6 md:py-8">
    <h1 class="text-h2 mb-6">Savatcha</h1>

    <div v-if="pending && !data" class="py-10 text-center text-ink-500">Yuklanmoqda...</div>
    <div v-else-if="error" class="py-10 text-center text-red-500">Xatolik yuz berdi.</div>

    <div v-else-if="items.length === 0" class="py-10 text-center text-ink-500">
      Savatchangiz bo'sh.
      <NuxtLink to="/catalog" class="mt-3 block font-semibold text-brand-700">Xarid qilishni boshlash →</NuxtLink>
    </div>

    <p v-if="qtyError" class="mb-4 rounded-md bg-red-50 px-3 py-2 text-small text-red-600" role="alert">
      {{ qtyError }}
    </p>

    <div v-else class="grid gap-6 lg:grid-cols-[1fr_360px]">
      <!-- Items -->
      <ul class="divide-y divide-line rounded-lg border border-line bg-surface">
        <li v-for="item in items" :key="item.id" class="flex flex-wrap items-center gap-4 p-4 sm:p-5">
          <NuxtLink :to="`/p/${item.slug}`" class="flex size-24 shrink-0 items-center justify-center overflow-hidden rounded-md bg-white">
            <img v-if="item.image" :src="item.image" :alt="item.name" class="h-full w-full object-contain" />
          </NuxtLink>

          <div class="min-w-0 flex-1">
            <p class="text-h3 tabular-nums">{{ formatSum(item.price) }}</p>
            <NuxtLink :to="`/p/${item.slug}`" class="mt-1 block font-medium text-ink-900 hover:text-brand-600">
              {{ item.name }} {{ item.variant_name }}
            </NuxtLink>
            <p class="mt-1 text-small text-ink-500">Mahsulot kodi: {{ item.sku }}</p>
          </div>

          <button class="p-2 text-ink-500 hover:text-red-500" aria-label="O'chirish" @click="remove(item)">
            <Trash2 class="size-5" />
          </button>

          <div class="flex items-center gap-3">
            <button class="flex size-8 items-center justify-center rounded-md bg-canvas disabled:opacity-40"
              :disabled="item.quantity <= 1" @click="changeQty(item, item.quantity - 1)">
              <Minus class="size-4" />
            </button>
            <span class="w-6 text-center tabular-nums">{{ item.quantity }}</span>
            <button class="flex size-8 items-center justify-center rounded-md bg-canvas disabled:opacity-40"
              :disabled="item.quantity >= item.stock" @click="changeQty(item, item.quantity + 1)">
              <Plus class="size-4" />
            </button>
          </div>
        </li>
      </ul>

      <!-- Summary -->
      <aside class="h-fit rounded-lg border border-line bg-surface p-5">
        <h2 class="text-h3 mb-4">Sizning savatchangiz</h2>
        <div v-for="item in items" :key="item.id" class="mb-4 border-b border-line pb-4 text-small">
          <p class="font-medium">{{ item.name }} {{ item.variant_name }} ({{ item.quantity }} dona)</p>
          <p class="mt-1 flex justify-between text-ink-500">
            <span>Narx</span><span class="tabular-nums">{{ formatSum(item.line_total) }}</span>
          </p>
        </div>
        <p class="mb-4 flex justify-between font-semibold">
          <span>Jami:</span><span class="tabular-nums">{{ formatSum(total) }}</span>
        </p>
        <NuxtLink to="/checkout"
          class="btn-press block w-full rounded-lg bg-brand-600 py-3 text-center font-medium text-white hover:bg-brand-700">
          Rasmiylashtirish
        </NuxtLink>
      </aside>
    </div>
  </div>
</template>