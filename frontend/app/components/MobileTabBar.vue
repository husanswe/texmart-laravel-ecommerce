<script setup lang="ts">
import { Heart, House, LayoutGrid, ShoppingBag, User } from '@lucide/vue'

const cart = useCartStore()
const favorites = useFavoritesStore()
const route = useRoute()

const items = computed(() => [
  { label: 'Bosh sahifa', to: '/', icon: House, count: 0 },
  { label: 'Katalog', to: '/catalog', icon: LayoutGrid, count: 0 },
  { label: 'Savatcha', to: '/cart', icon: ShoppingBag, count: cart.count },
  { label: 'Sevimlilar', to: '/favorites', icon: Heart, count: favorites.count },
  { label: 'Profil', to: '/cabinet', icon: User, count: 0 },
])

const isActive = (to: string) => (to === '/' ? route.path === '/' : route.path.startsWith(to))
</script>

<template>
  <nav
    class="fixed inset-x-0 bottom-0 z-40 border-t border-line bg-surface lg:hidden"
    style="padding-bottom: env(safe-area-inset-bottom)"
    aria-label="Asosiy navigatsiya"
  >
    <ul class="flex h-14 items-stretch">
      <li v-for="item in items" :key="item.to" class="flex-1">
        <NuxtLink
          :to="item.to"
          class="flex h-full flex-col items-center justify-center gap-1 transition-colors"
          :class="isActive(item.to) ? 'text-brand-500' : 'text-ink-500'"
          :aria-current="isActive(item.to) ? 'page' : undefined"
        >
          <span class="relative">
            <component :is="item.icon" class="size-5.5" aria-hidden="true" />
            <span
              v-if="item.count > 0"
              class="absolute -top-1.5 -right-2 grid h-[18px] min-w-[18px] place-items-center rounded-full bg-brand-500 px-1 text-[11px] leading-none font-semibold text-white tnum"
            >
              {{ item.count }}
            </span>
          </span>
          <span class="text-[11px] leading-none">{{ item.label }}</span>
        </NuxtLink>
      </li>
    </ul>
  </nav>
</template>
