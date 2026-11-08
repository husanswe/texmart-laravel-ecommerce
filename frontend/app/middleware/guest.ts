/** Login and register pages are for guests only. */
export default defineNuxtRouteMiddleware(() => {
  const auth = useAuthStore()
  if (auth.isLoggedIn) return navigateTo('/cabinet')
})