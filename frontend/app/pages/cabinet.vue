<script setup lang="ts">
import { LogOut } from '@lucide/vue'

definePageMeta({ middleware: 'auth' })
useSeoMeta({ title: 'Mening profilim' })

const auth = useAuthStore()

// On a direct visit the user may not be loaded yet.
onMounted(() => {
  if (!auth.user) auth.fetchMe()
})
</script>


<template>
  <div class="container-page py-6 md:py-8">
    <h1 class="text-h2 mb-6">Mening profilim</h1>

    <div class="max-w-xl rounded-lg border border-line bg-surface p-6">
      <div v-if="!auth.user" class="text-ink-500">Yuklanmoqda...</div>

      <dl v-else class="space-y-4">
        <div>
          <dt class="text-small text-ink-500">Ism va familiya</dt>
          <dd class="mt-0.5 font-medium text-ink-900">{{ auth.user.name }}</dd>
        </div>
        <div>
          <dt class="text-small text-ink-500">Telefon raqami</dt>
          <dd class="mt-0.5 font-medium text-ink-900 tnum">{{ auth.user.phone }}</dd>
        </div>
        <div v-if="auth.user.email">
          <dt class="text-small text-ink-500">E-mail</dt>
          <dd class="mt-0.5 font-medium text-ink-900">{{ auth.user.email }}</dd>
        </div>
      </dl>

      <button
        type="button"
        class="btn-press mt-6 inline-flex h-11 items-center gap-2 rounded-lg border border-line px-5 font-medium text-ink-700 transition hover:border-red-300 hover:text-red-600"
        @click="auth.logout()"
      >
        <LogOut class="size-4" aria-hidden="true" />
        Chiqish
      </button>
    </div>
  </div>
</template>