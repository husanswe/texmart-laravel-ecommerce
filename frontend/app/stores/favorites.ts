import { defineStore } from 'pinia'

export const useFavoritesStore = defineStore('favorites', () => {
  const ids = ref<number[]>([])
  const count = computed(() => ids.value.length)
  const has = (id: number) => ids.value.includes(id)

  function persist() {
    localStorage.setItem('favorites', JSON.stringify(ids.value))
  }

  function hydrate() {
    try {
      ids.value = JSON.parse(localStorage.getItem('favorites') ?? '[]')
    } catch {
      ids.value = []
    }
  }

  function toggle(id: number) {
    ids.value = has(id) ? ids.value.filter((i) => i !== id) : [...ids.value, id]
    persist()
  }

  return { ids, count, has, hydrate, toggle }
})
