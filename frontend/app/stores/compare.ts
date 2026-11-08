import { defineStore } from 'pinia'

/** Matches the backend rule `ids => max:4` on GET /products/compare. */
export const MAX_COMPARE = 4

export const useCompareStore = defineStore('compare', () => {
  const ids = ref<number[]>([])
  const count = computed(() => ids.value.length)
  const has = (id: number) => ids.value.includes(id)
  const isFull = computed(() => ids.value.length >= MAX_COMPARE)

  function hydrate(saved: number[]) {
    ids.value = saved
  }

  function toggle(id: number) {
    if (has(id)) {
      ids.value = ids.value.filter((i) => i !== id)
    } else {
      if (isFull.value) return
      ids.value = [...ids.value, id]
    }
  }

  function clear() {
    ids.value = []
  }

  return { ids, count, has, isFull, hydrate, toggle, clear }
})