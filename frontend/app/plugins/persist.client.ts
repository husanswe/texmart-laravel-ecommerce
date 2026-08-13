import type { CartLine } from '~/types'

const KEYS = {
  cart: 'texmart:cart',
  favorites: 'texmart:favorites',
  compare: 'texmart:compare',
} as const

function read<T>(key: string, fallback: T): T {
  try {
    const raw = localStorage.getItem(key)
    return raw ? (JSON.parse(raw) as T) : fallback
  } catch {
    // Corrupt or unavailable storage must never stop the app from rendering.
    return fallback
  }
}

function write(key: string, value: unknown) {
  try {
    localStorage.setItem(key, JSON.stringify(value))
  } catch {
    // Private mode or a full quota — losing persistence is not worth an error.
  }
}

/**
 * Cart, favorites and compare survive a refresh.
 *
 * Rehydration deliberately waits for `app:suspense:resolve` — the stores are
 * empty during SSR and through hydration, so the server and client markup agree.
 * Filling them earlier is what produces hydration mismatch warnings on the
 * header count badges.
 */
export default defineNuxtPlugin((nuxtApp) => {
  const cart = useCartStore()
  const favorites = useFavoritesStore()
  const compare = useCompareStore()

  nuxtApp.hook('app:suspense:resolve', () => {
    cart.hydrate(read<CartLine[]>(KEYS.cart, []))
    favorites.hydrate(read<number[]>(KEYS.favorites, []))
    compare.hydrate(read<number[]>(KEYS.compare, []))

    watch(() => cart.lines, (v) => write(KEYS.cart, v), { deep: true })
    watch(() => favorites.ids, (v) => write(KEYS.favorites, v), { deep: true })
    watch(() => compare.ids, (v) => write(KEYS.compare, v), { deep: true })
  })
})
