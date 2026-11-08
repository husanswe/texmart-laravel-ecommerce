<script setup lang="ts">
definePageMeta({ middleware: 'guest' })
useSeoMeta({ title: "Ro'yxatdan o'tish" })

const auth = useAuthStore()

const form = reactive({ name: '', phone: '', password: '', password_confirmation: '' })
const loading = ref(false)
const errorMessage = ref('')

async function submit() {
  errorMessage.value = ''
  if (form.password !== form.password_confirmation) {
    errorMessage.value = 'Parollar mos kelmadi.'
    return
  }
  loading.value = true
  try {
    await auth.register({ ...form, phone: normalizePhone(form.phone) })
    await navigateTo('/cabinet')
  } catch (e) {
    errorMessage.value = apiErrorMessage(e)
  } finally {
    loading.value = false
  }
}

const inputClass =
  'mt-1 h-12 w-full rounded-md border border-line bg-white px-4 text-ink-900 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20'
</script>

<template>
  <div class="container-page flex justify-center py-10 md:py-16">
    <form class="w-full max-w-md rounded-lg border border-line bg-surface p-6 md:p-8" @submit.prevent="submit">
      <h1 class="text-h2">Ro'yxatdan o'tish</h1>

      <label class="mt-6 block">
        <span class="text-small font-medium text-ink-700">Ism va familiya</span>
        <input v-model="form.name" type="text" autocomplete="name" required maxlength="255" :class="inputClass" />
      </label>

      <label class="mt-4 block">
        <span class="text-small font-medium text-ink-700">Telefon raqami</span>
        <input
          v-model="form.phone"
          type="tel"
          inputmode="tel"
          autocomplete="tel"
          placeholder="+998 90 123 45 67"
          required
          :class="inputClass"
        />
      </label>

      <label class="mt-4 block">
        <span class="text-small font-medium text-ink-700">Parol (kamida 8 belgi)</span>
        <input v-model="form.password" type="password" autocomplete="new-password" required minlength="8" :class="inputClass" />
      </label>

      <label class="mt-4 block">
        <span class="text-small font-medium text-ink-700">Parolni tasdiqlang</span>
        <input
          v-model="form.password_confirmation"
          type="password"
          autocomplete="new-password"
          required
          minlength="8"
          :class="inputClass"
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
        {{ loading ? 'Yuborilmoqda...' : "Ro'yxatdan o'tish" }}
      </button>

      <p class="mt-4 text-center text-small text-ink-500">
        Hisobingiz bormi?
        <NuxtLink to="/login" class="font-semibold text-brand-700 hover:text-brand-500">Kirish</NuxtLink>
      </p>
    </form>
  </div>
</template>