import { ofetch } from 'ofetch'
import type { FetchOptions } from 'ofetch'

export function useApi<T>(path: string, options: FetchOptions<'json'> = {}): Promise<T> {
  const { apiBase } = useRuntimeConfig().public

  let currentLang = 'uz'
  try {
    if (typeof useLocaleStore === 'function') {
      const store = useLocaleStore()
      if (store?.current) {
        currentLang = store.current
      }
    }
  } catch {
    // Fallback if Pinia store is uninitialized during SSR
  }

  // Sanctum: attach the bearer token when the user is logged in.
  const authHeader: Record<string, string> = {}
  try {
    const auth = useAuthStore()
    if (auth.token) authHeader.Authorization = `Bearer ${auth.token}`
  } catch {
    // Store not available yet — the request goes out as a guest.
  }

  return ofetch<T>(path, {
      baseURL: apiBase,
      ...options,
      query: { lang: currentLang, ...options.query },
      headers: {
        Accept: 'application/json',
        'Accept-Language': currentLang,
        ...authHeader,
        ...options.headers,
      },
    })
  }

export function usingMocks(): boolean {
  return useRuntimeConfig().public.useMocks === true
}
