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

  return ofetch<T>(path, {
    baseURL: apiBase,
    ...options,
    headers: {
      Accept: 'application/json',
      ...options.headers,
    },
  })
}

/** True when the app is serving fixtures rather than calling the API. */
export function usingMocks(): boolean {
  return useRuntimeConfig().public.useMocks === true
}
