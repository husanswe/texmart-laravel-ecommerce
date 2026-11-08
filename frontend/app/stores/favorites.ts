import { defineStore } from 'pinia'

export const useFavoritesStore = defineStore('favorites', () => {
  const ids = ref<number[]>([])
  const count = computed(() => ids.value.length)
  const has = (id: number) => ids.value.includes(id)

  function hydrate(saved: number[]) {
    ids.value = saved
  }

  function toggle(id: number) {
    ids.value = has(id) ? ids.value.filter((i) => i !== id) : [...ids.value, id]
  }

  return { ids, count, has, hydrate, toggle }
})