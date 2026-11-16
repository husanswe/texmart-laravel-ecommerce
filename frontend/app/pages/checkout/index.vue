<script setup lang="ts">
import { ShoppingBag } from '@lucide/vue'
import type { CartSummary, Order } from '~/types'

// Orders are tied to an account on the backend, so guests are sent to /login
// and brought back here afterwards; the guest cart merges into the account.
definePageMeta({ middleware: 'auth' })
useSeoMeta({ title: 'Rasmiylashtirish', robots: 'noindex, nofollow' })

const auth = useAuthStore()
const cartStore = useCartStore()

onMounted(() => {
  if (!auth.user) auth.fetchMe()
})

/* ── Cart summary ───────────────────────────────────────────────────────── */
const cartHeaders = () => ({ 'X-Cart-Token': localStorage.getItem('cart_token') ?? '' })

const {
  data: cart,
  pending,
  error: cartError,
  refresh,
} = await useAsyncData(
  'checkout-cart',
  () => useApi<CartSummary>('/cart', { headers: cartHeaders() }),
  { server: false },
)

const items = computed(() => cart.value?.items ?? [])
const total = computed(() => cart.value?.total ?? 0)
const isEmpty = computed(() => !pending.value && items.value.length === 0)

// The header badge reads the store, which only knows what localStorage held.
// Once signed in the server cart is the source of truth, so mirror it into the
// store the same way the cart page does — otherwise the badge can read 0 while
// the summary beside it lists items.
watch(cart, (value) => {
  if (!value) return
  cartStore.hydrate(
    value.items.map((i) => ({ productId: i.product_id, variantId: i.variant_id, qty: i.quantity })),
  )
})

/* ── Form ───────────────────────────────────────────────────────────────── */
// Only the two fields the API persists. Delivery and payment options are not
// modelled on the backend yet, so the page does not pretend to collect them.
const form = reactive({ phone: '', address: '' })
const touched = reactive({ phone: false, address: false })

// Prefill the phone from the profile once it is known, without clobbering
// anything the user has already typed.
watch(
  () => auth.user,
  (user) => {
    if (user?.phone && !form.phone) form.phone = user.phone
  },
  { immediate: true },
)

function validatePhone(value: string): string {
  const trimmed = value.trim()
  if (!trimmed) return 'Telefon raqamini kiriting'
  const digits = trimmed.replace(/\D/g, '')
  if (digits.length < 9 || trimmed.length > 20) {
    return "Telefon raqami noto'g'ri. Masalan: +998 90 123 45 67"
  }
  return ''
}

function validateAddress(value: string): string {
  const trimmed = value.trim()
  if (!trimmed) return 'Yetkazib berish manzilini kiriting'
  if (trimmed.length < 10) return "Manzilni to'liqroq yozing: shahar, ko'cha, uy va xonadon"
  if (trimmed.length > 255) return 'Manzil 255 ta belgidan oshmasligi kerak'
  return ''
}

const errors = computed(() => ({
  phone: validatePhone(form.phone),
  address: validateAddress(form.address),
}))
const isValid = computed(() => !errors.value.phone && !errors.value.address)

/* ── Submit ─────────────────────────────────────────────────────────────── */
const submitting = ref(false)
const serverError = ref('')

async function placeOrder() {
  touched.phone = true
  touched.address = true
  if (!isValid.value || items.value.length === 0) return

  submitting.value = true
  serverError.value = ''
  try {
    const res = await useApi<{ message: string; data: Order }>('/orders', {
      method: 'POST',
      body: {
        shipping_address: form.address.trim(),
        phone: form.phone.trim(),
      },
    })
    // The server has emptied the cart; mirror that in the header badge.
    cartStore.clear()
    await navigateTo(`/checkout/success/${res.data.id}`)
  } catch (e) {
    // Field problems are shown under the fields; this is for the rest —
    // an empty cart, or stock that ran out between the cart and the order.
    serverError.value = apiErrorMessage(e)
    await refresh()
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <div class="container-page py-6 md:py-8">
    <UiBreadcrumb
      :items="[
        { label: 'Bosh sahifa', to: '/' },
        { label: 'Savatcha', to: '/cart' },
        { label: 'Rasmiylashtirish' },
      ]"
    />
    <h1 class="mt-4 mb-6 text-h2-m md:text-h2">Buyurtmani rasmiylashtirish</h1>

    <!-- Loading -->
    <div v-if="pending && !cart" class="grid gap-6 lg:grid-cols-[1fr_360px]">
      <UiSkeleton class="h-80 w-full" rounded="lg" />
      <UiSkeleton class="h-64 w-full" rounded="lg" />
    </div>

    <div v-else-if="cartError" class="rounded-lg border border-line bg-surface p-6 text-body text-out">
      Savatchani yuklab bo'lmadi. Sahifani yangilab ko'ring.
    </div>

    <!-- Nothing to order -->
    <UiEmptyState
      v-else-if="isEmpty"
      :icon="ShoppingBag"
      title="Savatchangiz bo'sh"
      description="Rasmiylashtirish uchun avval mahsulot tanlang."
    >
      <UiButton to="/catalog">Katalogga o'tish</UiButton>
    </UiEmptyState>

    <form v-else class="grid gap-6 lg:grid-cols-[1fr_360px]" novalidate @submit.prevent="placeOrder">
      <!-- ── Left: details ───────────────────────────────────────────── -->
      <div class="space-y-6">
        <section class="rounded-lg border border-line bg-surface p-5 sm:p-6">
          <h2 class="mb-4 text-h3-m md:text-h3">1. Aloqa ma'lumotlari</h2>
          <div class="grid gap-4 sm:grid-cols-2">
            <UiInput
              :model-value="auth.user?.name ?? ''"
              label="Ism va familiya"
              hint="Profilingizdan olindi"
              disabled
            />
            <UiInput
              v-model="form.phone"
              label="Telefon raqami"
              type="tel"
              inputmode="tel"
              autocomplete="tel"
              placeholder="+998 90 123 45 67"
              required
              numeric
              :error="touched.phone ? errors.phone || undefined : undefined"
              hint="Buyurtmani tasdiqlash uchun qo'ng'iroq qilamiz"
              @focusout="touched.phone = true"
            />
          </div>
        </section>

        <section class="rounded-lg border border-line bg-surface p-5 sm:p-6">
          <h2 class="mb-4 text-h3-m md:text-h3">2. Yetkazib berish manzili</h2>
          <UiInput
            v-model="form.address"
            label="Manzil"
            autocomplete="street-address"
            placeholder="Toshkent, Chilonzor tumani, 5-kvartal, 12-uy, 34-xonadon"
            required
            :error="touched.address ? errors.address || undefined : undefined"
            hint="Shahar, tuman, ko'cha, uy va xonadon raqami"
            @focusout="touched.address = true"
          />
          <p class="mt-4 text-small text-ink-500">
            Yetkazib berish O'zbekiston bo'ylab 1–3 kun ichida. Narxi va to'lov usuli operator
            buyurtmani tasdiqlaganda kelishiladi.
          </p>
        </section>
      </div>

      <!-- ── Right: summary ──────────────────────────────────────────── -->
      <aside class="h-fit rounded-lg border border-line bg-surface p-5 lg:sticky lg:top-24">
        <h2 class="mb-4 text-h3-m md:text-h3">Buyurtmangiz</h2>

        <ul class="divide-y divide-line">
          <li v-for="item in items" :key="item.id" class="flex gap-3 py-3">
            <div class="grid size-14 shrink-0 place-items-center overflow-hidden rounded-md bg-canvas">
              <img v-if="item.image" :src="item.image" :alt="item.name" class="size-full object-contain" />
            </div>
            <div class="min-w-0 flex-1">
              <p class="truncate text-small font-medium text-ink-900">
                {{ item.name }} {{ item.variant_name }}
              </p>
              <p class="mt-0.5 text-small text-ink-500 tnum">
                {{ item.quantity }} × {{ formatSum(item.price) }}
              </p>
            </div>
            <p class="shrink-0 text-small font-semibold text-ink-900 tnum">
              {{ formatSum(item.line_total) }}
            </p>
          </li>
        </ul>

        <dl class="mt-4 space-y-2 border-t border-line pt-4 text-body">
          <div class="flex justify-between text-ink-500">
            <dt>Mahsulotlar</dt>
            <dd class="tnum">{{ formatSum(total) }}</dd>
          </div>
          <div class="flex justify-between text-ink-500">
            <dt>Yetkazib berish</dt>
            <dd>Kelishiladi</dd>
          </div>
          <div class="flex justify-between text-h3-m font-bold text-ink-900 md:text-h3">
            <dt>Jami</dt>
            <dd class="tnum">{{ formatSum(total) }}</dd>
          </div>
        </dl>

        <p
          v-if="serverError"
          class="mt-4 rounded-md border border-out/30 bg-out/5 px-3 py-2 text-small text-out"
          role="alert"
        >
          {{ serverError }}
        </p>

        <UiButton
          type="submit"
          size="lg"
          block
          class="mt-5"
          :loading="submitting"
          :disabled="items.length === 0"
        >
          Buyurtma berish
        </UiButton>
        <p class="mt-3 text-center text-small text-ink-500">
          Tugmani bosish orqali
          <NuxtLink to="/oferta" class="text-brand-700 underline-offset-2 hover:underline">
            ommaviy oferta
          </NuxtLink>
          shartlariga rozilik bildirasiz.
        </p>
      </aside>
    </form>
  </div>
</template>
