<script setup lang="ts">
import { CircleCheck, PackageSearch } from '@lucide/vue'
import type { Order, OrderStatus } from '~/types'

definePageMeta({ middleware: 'auth' })
useSeoMeta({ title: 'Buyurtma qabul qilindi', robots: 'noindex, nofollow' })

const route = useRoute()
const id = computed(() => String(route.params.id))

// Fetched rather than passed through the router, so a refresh or a shared
// link still shows the order. The endpoint is scoped to the signed-in user.
const { data, pending, error } = await useAsyncData(
  () => `order-${id.value}`,
  () => useApi<{ data: Order }>(`/orders/${id.value}`),
  { server: false },
)

const order = computed(() => data.value?.data ?? null)
const items = computed(() => order.value?.order_items ?? [])

const STATUS_LABEL: Record<OrderStatus, string> = {
  pending: 'Kutilmoqda',
  confirmed: 'Tasdiqlandi',
  shipped: "Yo'lda",
  delivered: 'Yetkazildi',
  cancelled: 'Bekor qilindi',
}

const STATUS_TONE: Record<OrderStatus, 'neutral' | 'brand' | 'install' | 'stock' | 'out'> = {
  pending: 'neutral',
  confirmed: 'brand',
  shipped: 'install',
  delivered: 'stock',
  cancelled: 'out',
}
</script>

<template>
  <div class="container-page py-6 md:py-8">
    <div v-if="pending && !data" class="mx-auto max-w-2xl">
      <UiSkeleton class="h-96 w-full" rounded="lg" />
    </div>

    <UiEmptyState
      v-else-if="error || !order"
      :icon="PackageSearch"
      title="Buyurtma topilmadi"
      description="Bu buyurtma mavjud emas yoki sizga tegishli emas."
    >
      <UiButton to="/cabinet" variant="secondary">Mening profilim</UiButton>
      <UiButton to="/catalog">Katalogga o'tish</UiButton>
    </UiEmptyState>

    <div v-else class="mx-auto max-w-2xl rounded-lg border border-line bg-surface p-6 sm:p-8">
      <div class="flex items-start gap-4">
        <span class="grid size-12 shrink-0 place-items-center rounded-full bg-stock/10 text-stock">
          <CircleCheck class="size-7" aria-hidden="true" />
        </span>
        <div class="min-w-0">
          <h1 class="text-h2-m md:text-h2">Buyurtmangiz qabul qilindi</h1>
          <p class="mt-1 text-body text-ink-500">
            Operatorimiz tez orada
            <span class="font-medium text-ink-900 tnum">{{ order.phone }}</span>
            raqamiga qo'ng'iroq qilib, buyurtmani tasdiqlaydi.
          </p>
        </div>
      </div>

      <dl class="mt-6 grid gap-4 rounded-lg bg-canvas p-4 sm:grid-cols-2">
        <div>
          <dt class="text-small text-ink-500">Buyurtma raqami</dt>
          <dd class="mt-0.5 font-mono text-body font-semibold text-ink-900">
            {{ order.order_number }}
          </dd>
        </div>
        <div>
          <dt class="text-small text-ink-500">Holati</dt>
          <dd class="mt-1">
            <UiBadge :tone="STATUS_TONE[order.status]">{{ STATUS_LABEL[order.status] }}</UiBadge>
          </dd>
        </div>
        <div>
          <dt class="text-small text-ink-500">Sana</dt>
          <dd class="mt-0.5 text-body text-ink-900 tnum">{{ formatDate(order.created_at) }}</dd>
        </div>
        <div>
          <dt class="text-small text-ink-500">Yetkazib berish manzili</dt>
          <dd class="mt-0.5 text-body text-ink-900">{{ order.shipping_address }}</dd>
        </div>
      </dl>

      <h2 class="mt-6 mb-2 text-h3-m md:text-h3">Mahsulotlar</h2>
      <ul class="divide-y divide-line border-y border-line">
        <li
          v-for="item in items"
          :key="item.id"
          class="flex items-center justify-between gap-4 py-3"
        >
          <div class="min-w-0">
            <p class="truncate text-body font-medium text-ink-900">{{ item.product_name }}</p>
            <p class="text-small text-ink-500 tnum">
              <span class="font-mono">{{ item.sku }}</span>
              · {{ item.quantity }} × {{ formatSum(item.price_at_purchase) }}
            </p>
          </div>
          <p class="shrink-0 font-semibold text-ink-900 tnum">
            {{ formatSum(item.price_at_purchase * item.quantity) }}
          </p>
        </li>
      </ul>

      <p class="mt-4 flex justify-between text-h3-m font-bold text-ink-900 md:text-h3">
        <span>Jami</span>
        <span class="tnum">{{ formatSum(order.total_amount) }}</span>
      </p>

      <div class="mt-6 flex flex-col gap-3 sm:flex-row">
        <UiButton to="/catalog" block>Xaridni davom ettirish</UiButton>
        <UiButton to="/cabinet" variant="secondary" block>Mening profilim</UiButton>
      </div>
    </div>
  </div>
</template>
