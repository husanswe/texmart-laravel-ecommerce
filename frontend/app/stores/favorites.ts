import { defineStore } from 'pinia'

export const useFavoritesStore = defineStore('favorites', () => {
  const ids = ref<number[]>([])

  const count = computed(() => ids.value.length)
  const has = (productId: number) => ids.value.includes(productId)

  function toggle(productId: number) {
    ids.value = has(productId)
      ? ids.value.filter((id) => id !== productId)
      : [...ids.value, productId]
  }

  function remove(productId: number) {
    ids.value = ids.value.filter((id) => id !== productId)
  }

  /** Called by the persistence plugin after mount, never during SSR. */
  function hydrate(saved: number[]) {
    ids.value = saved
  }

  return { ids, count, has, toggle, remove, hydrate }
})
