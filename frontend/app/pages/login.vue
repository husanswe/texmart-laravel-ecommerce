<script setup lang="ts">
definePageMeta({ middleware: 'guest' })
useSeoMeta({ title: 'Kirish' })

const auth = useAuthStore()
const route = useRoute()

const phone = ref('')
const password = ref('')
const loading = ref(false)
const errorMessage = ref('')

async function submit() {
  errorMessage.value = ''
  loading.value = true
  try {
    await auth.login(normalizePhone(phone.value), password.value)
    await navigateTo((route.query.redirect as string) || '/cabinet')
  } catch (e) {
    errorMessage.value = apiErrorMessage(e)
  } finally {
    loading.value = false
  }
}
</script>


<template>
  <div class="container-page flex justify-center py-10 md:py-16">
    <form class="w-full max-w-md rounded-lg border border-line bg-surface p-6 md:p-8" @submit.prevent="submit">
      <h1 class="text-h2">Kirish</h1>
      <p class="mt-1 text-small text-ink-500">Telefon raqamingiz va parolingizni kiriting.</p>

      <label class="mt-6 block">
        <span class="text-small font-medium text-ink-700">Telefon raqami</span>
        <input
          v-model="phone"
          type="tel"
          inputmode="tel"
          autocomplete="tel"
          placeholder="+998 90 123 45 67"
          required
          class="mt-1 h-12 w-full rounded-md border border-line bg-white px-4 text-ink-900 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
        />
      </label>

      <label class="mt-4 block">
        <span class="text-small font-medium text-ink-700">Parol</span>
        <input
          v-model="password"
          type="password"
          autocomplete="current-password"
          required
          class="mt-1 h-12 w-full rounded-md border border-line bg-white px-4 text-ink-900 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
        />
      </label>

      <p v-if="errorMessage" class="mt-4 rounded-md bg-red-50 px-3 py-2 text-small text-red-600" role="alert">
        {{ errorMessage }}
      </p>

      <button
        type="submit"
        :disabled="loading"
        class="btn-press mt-6 h-12 w-full rounded-lg bg-brand-600 font-semibold text-white transition hover:bg-brand-700 disabled:opacity-60"
      >
        {{ loading ? 'Kirilmoqda...' : 'Kirish' }}
      </button>

      <p class="mt-4 text-center text-small text-ink-500">
        Hisobingiz yo'qmi?
        <NuxtLink to="/register" class="font-semibold text-brand-700 hover:text-brand-500">Ro'yxatdan o'tish</NuxtLink>
      </p>
    </form>
  </div>
</template>