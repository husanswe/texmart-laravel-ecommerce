import { defineStore } from 'pinia'

export interface AuthUser {
  id: number
  name: string
  phone: string
  email: string | null
  avatar: string | null
  is_admin: boolean
  birth_date: string | null
}

interface AuthResponse {
  message: string
  user: AuthUser
  token: string
}

/**
 * Sanctum token auth. The token lives in a cookie (not localStorage) so the
 * server side of Nuxt can read it too — that is what lets route middleware
 * protect /cabinet during SSR without a flash of the wrong page.
 */
export const useAuthStore = defineStore('auth', () => {
  const token = useCookie<string | null>('auth_token', {
    maxAge: 60 * 60 * 24 * 30, // 30 days
    sameSite: 'lax',
    default: () => null,
  })
  const user = ref<AuthUser | null>(null)
  const isLoggedIn = computed(() => !!token.value)

  /** Sends the guest cart token so Laravel can merge the guest cart into the account. */
  function cartHeader(): Record<string, string> {
    if (import.meta.server) return {}
    const cartToken = localStorage.getItem('cart_token')
    return cartToken ? { 'X-Cart-Token': cartToken } : {}
  }

  async function afterAuth(res: AuthResponse) {
    token.value = res.token
    user.value = res.user
    // Push favorites picked as a guest to the account, pull the account's list back.
    await useFavoritesStore().syncWithServer().catch(() => {})
  }

  async function login(phone: string, password: string) {
    const res = await useApi<AuthResponse>('/login', {
      method: 'POST',
      body: { phone, password },
      headers: cartHeader(),
    })
    await afterAuth(res)
  }

  async function register(payload: {
    name: string
    phone: string
    password: string
    password_confirmation: string
  }) {
    const res = await useApi<AuthResponse>('/register', {
      method: 'POST',
      body: payload,
      headers: cartHeader(),
    })
    await afterAuth(res)
  }

  async function fetchMe() {
    if (!token.value) return
    try {
      const res = await useApi<{ user: AuthUser }>('/me')
      user.value = res.user
    } catch (e: any) {
      // Token expired or was revoked on the server — forget it.
      if (e?.response?.status === 401) {
        token.value = null
        user.value = null
      }
    }
  }

  async function logout() {
    try {
      await useApi('/logout', { method: 'POST' })
    } catch {
      // Logging out locally matters more than the server call succeeding.
    }
    token.value = null
    user.value = null
    await navigateTo('/')
  }

  return { token, user, isLoggedIn, login, register, fetchMe, logout }
})