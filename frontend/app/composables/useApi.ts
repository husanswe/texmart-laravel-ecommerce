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

  return ofetch<T>(path, {
    baseURL: apiBase,
    ...options,
    query: { lang: currentLang, ...options.query },
    headers: {
      Accept: 'application/json',
      'Accept-Language': currentLang,
      ...options.headers,
    },
  })
}

export function usingMocks(): boolean {
  return useRuntimeConfig().public.useMocks === true
}
