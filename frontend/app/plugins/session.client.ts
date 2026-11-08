/**
 * Restores the logged-in user after a page refresh.
 *
 * The file name matters: Nuxt runs plugins alphabetically, so this one ("s")
 * registers its hook after persist.client.ts ("p"). That way localStorage
 * favorites are loaded first, then merged with the account's favorites.
 */
export default defineNuxtPlugin((nuxtApp) => {
  // Created here, inside the Nuxt context, so useCookie() in the store works.
  const auth = useAuthStore()
  const favorites = useFavoritesStore()

  nuxtApp.hook('app:suspense:resolve', async () => {
    if (!auth.isLoggedIn) return
    await auth.fetchMe()
    if (auth.isLoggedIn) await favorites.syncWithServer().catch(() => {})
  })
})