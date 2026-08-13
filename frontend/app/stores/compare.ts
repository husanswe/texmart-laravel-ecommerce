import { defineStore } from 'pinia'

/** The compare table is unreadable beyond four columns. */
export const COMPARE_LIMIT = 4

export const useCompareStore = defineStore('compare', () => {
  const ids = ref<number[]>([])

  const count = computed(() => ids.value.length)
  const isFull = computed(() => ids.value.length >= COMPARE_LIMIT)
  const has = (productId: number) => ids.value.includes(productId)

  /**
   * Returns false when the list is already full, so the caller can tell the
   * user why nothing happened instead of failing silently.
   */
  function add(productId: number): boolean {
    if (has(productId)) return true
    if (isFull.value) return false
    ids.value = [...ids.value, productId]
    return true
  }

  function remove(productId: number) {
    ids.value = ids.value.filter((id) => id !== productId)
  }

  function toggle(productId: number): boolean {
    if (has(productId)) {
      remove(productId)
      return true
    }
    return add(productId)
  }

  function clear() {
    ids.value = []
  }

  function hydrate(saved: number[]) {
    ids.value = saved.slice(0, COMPARE_LIMIT)
  }

  return { ids, count, isFull, has, add, remove, toggle, clear, hydrate }
})
