import { defineStore } from 'pinia'
import type { CartLine } from '~/types'

export const useCartStore = defineStore('cart', () => {
  const lines = ref<CartLine[]>([])

  /** Distinct products, which is what the header badge shows. */
  const count = computed(() => lines.value.length)
  const totalQty = computed(() => lines.value.reduce((sum, l) => sum + l.qty, 0))

  const has = (productId: number) => lines.value.some((l) => l.productId === productId)

  function add(productId: number, variantId: number, qty = 1) {
    const existing = lines.value.find(
      (l) => l.productId === productId && l.variantId === variantId,
    )
    if (existing) {
      existing.qty += qty
      lines.value = [...lines.value]
      return
    }
    lines.value = [...lines.value, { productId, variantId, qty }]
  }

  function setQty(productId: number, variantId: number, qty: number) {
    if (qty <= 0) return remove(productId, variantId)
    lines.value = lines.value.map((l) =>
      l.productId === productId && l.variantId === variantId ? { ...l, qty } : l,
    )
  }

  function remove(productId: number, variantId: number) {
    lines.value = lines.value.filter(
      (l) => !(l.productId === productId && l.variantId === variantId),
    )
  }

  function clear() {
    lines.value = []
  }

  function hydrate(saved: CartLine[]) {
    lines.value = saved
  }

  return { lines, count, totalQty, has, add, setQty, remove, clear, hydrate }
})
