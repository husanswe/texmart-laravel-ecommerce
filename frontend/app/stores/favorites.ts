import { defineStore } from 'pinia'

/**
 * Favorite product ids. Guests keep them in localStorage only (persist.client.ts
 * saves them). Logged-in users also get every change written to Laravel.
 */
export const useFavoritesStore = defineStore('favorites', () => {
  const ids = ref<number[]>([])
  const count = computed(() => ids.value.length)
  const has = (id: number) => ids.value.includes(id)

  function hydrate(saved: number[]) {
    ids.value = saved
  }

  async function toggle(id: number) {
    const adding = !has(id)
    // Update the UI first, so the heart reacts instantly.
    ids.value = adding ? [...ids.value, id] : ids.value.filter((i) => i !== id)

    const auth = useAuthStore()
    if (!auth.isLoggedIn) return

    try {
      if (adding) {
        await useApi('/favorites', { method: 'POST', body: { product_id: id } })
      } else {
        await useApi(`/favorites/${id}`, { method: 'DELETE' })
      }
    } catch {
      // Server refused — undo the optimistic change.
      ids.value = adding ? ids.value.filter((i) => i !== id) : [...ids.value, id]
    }
  }

  async function syncWithServer() {
    const res = await useApi<{ ids: number[] }>('/favorites/sync', {
      method: 'POST',
      body: { ids: ids.value },
    })
    ids.value = res.ids
  }

  function clear() {
    ids.value = []
  }

  return { ids, count, has, hydrate, toggle, syncWithServer, clear }
})