<script setup lang="ts">
import { Search } from '@lucide/vue'

withDefaults(defineProps<{ size?: 'md' | 'lg' }>(), { size: 'lg' })

const router = useRouter()
const route = useRoute()

const query = ref(typeof route.query.q === 'string' ? route.query.q : '')

function submit() {
  const q = query.value.trim()
  if (!q) return
  router.push({ path: '/search', query: { q } })
}
</script>

<template>
  <form class="relative w-full" role="search" @submit.prevent="submit">
    <label for="site-search" class="sr-only">Mahsulotlar bo'yicha qidiruv</label>
    <input
      id="site-search"
      v-model="query"
      type="search"
      name="q"
      placeholder="Qidiruv"
      autocomplete="off"
      class="w-full rounded-md border border-line bg-surface pl-4 text-body text-ink-900 transition-colors outline-none placeholder:text-ink-300 hover:border-brand-300 focus:border-brand-500"
      :class="size === 'lg' ? 'h-12 pr-12' : 'h-11 pr-11'"
    />
    <button
      type="submit"
      class="absolute inset-y-0 right-0 grid place-items-center rounded-r-md text-ink-500 transition-colors hover:text-brand-600"
      :class="size === 'lg' ? 'w-12' : 'w-11'"
      aria-label="Qidirish"
    >
      <Search class="size-5" aria-hidden="true" />
    </button>
  </form>
</template>
