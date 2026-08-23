import { ofetch } from 'ofetch'
import type { FetchOptions } from 'ofetch'

/**
 * The single place the app talks to the network. Repositories call this;
 * pages and components never do. When the Laravel API is ready, flipping
 * NUXT_PUBLIC_USE_MOCKS to false is the entire migration.
 *
 * This uses `ofetch` rather than Nuxt's global `$fetch` on purpose: the global
 * is typed against the app's own Nitro routes, so an external URL sends the
 * compiler down a route-matching type recursion that blows the stack depth.
 */
export function useApi<T>(path: string, options: FetchOptions<'json'> = {}): Promise<T> {
  const { apiBase } = useRuntimeConfig().public
  const locale = useLocaleStore()

  return ofetch<T>(path, {
    baseURL: apiBase,
    ...options,
    // The chosen interface language travels with every request, so Laravel's
    // translatable content comes back in the right language. Sent both ways
    // because `Accept-Language` is the standard and `?lang=` is easier to see
    // in logs and to cache on.
    query: { lang: locale.current, ...options.query },
    headers: {
      Accept: 'application/json',
      'Accept-Language': locale.current,
      ...options.headers,
    },
  })
}

/** True when the app is serving fixtures rather than calling the API. */
export function usingMocks(): boolean {
  return useRuntimeConfig().public.useMocks === true
}
