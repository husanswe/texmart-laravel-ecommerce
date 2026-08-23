<script setup lang="ts">
import { Clock, Mail, Phone } from '@lucide/vue'
import type { SocialNetwork } from '~/components/SocialIcon.vue'

const COLUMNS = [
  {
    title: 'Xaridorlarga',
    links: [
      { label: 'Savol-javob', to: '/help/faq' },
      { label: 'Saytda buyurtma berish', to: '/help/order' },
      { label: 'Qaytarish va almashtirish', to: '/help/returns' },
    ],
  },
  {
    title: 'Texmart',
    links: [
      { label: 'Biz haqimizda', to: '/about' },
      { label: "Bizning do'konlarimiz", to: '/shops' },
      { label: 'Aloqa', to: '/contact' },
    ],
  },
  {
    title: "Ma'lumot",
    links: [
      { label: 'Maqolalar', to: '/blog' },
      { label: "Muddatli to'lov", to: '/installment' },
      { label: 'Oferta', to: '/oferta' },
      { label: 'Vakansiyalar', to: '/careers' },
    ],
  },
]

const SOCIAL: { label: string; network: SocialNetwork; href: string }[] = [
  { label: 'Telegram', network: 'telegram', href: 'https://t.me/husanswe' },
  {
    label: 'LinkedIn',
    network: 'linkedin',
    href: 'https://www.linkedin.com/in/husan-sulaymon-6a2495264/',
  },
  { label: 'X', network: 'x', href: 'https://x.com/husanswe' },
]

const year = new Date().getFullYear()
</script>

<template>
  <footer class="mt-auto bg-ink-900 text-ink-300">
    <div class="container-page py-10 md:py-14">
      <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-[1.2fr_1fr_1fr_1fr_1.3fr]">
        <!-- Wordmark + social -->
        <div>
          <TexmartLogo tone="dark" />
          <p class="mt-3 max-w-[34ch] text-small text-ink-500">
            Maishiy texnika va elektronika. O'zbekiston bo'ylab yetkazib berish.
          </p>
          <ul class="mt-5 flex items-center gap-3">
            <li v-for="item in SOCIAL" :key="item.label">
              <a
                :href="item.href"
                target="_blank"
                rel="noopener noreferrer"
                class="block rounded-full transition-opacity hover:opacity-85"
                :aria-label="item.label"
              >
                <SocialIcon :network="item.network" />
              </a>
            </li>
          </ul>
        </div>

        <!-- Link columns -->
        <nav v-for="column in COLUMNS" :key="column.title" :aria-label="column.title">
          <h2 class="mb-4 text-h3-m text-white md:text-h3">{{ column.title }}</h2>
          <ul class="space-y-2.5">
            <li v-for="link in column.links" :key="link.label">
              <NuxtLink
                :to="link.to"
                class="text-body text-ink-300 transition-colors hover:text-white"
              >
                {{ link.label }}
              </NuxtLink>
            </li>
          </ul>
        </nav>

        <!-- Contact -->
        <div>
          <h2 class="mb-4 text-h3-m text-white md:text-h3">Qayta aloqa</h2>
          <UiButton variant="secondary" class="!border-white/25 !bg-transparent !text-white hover:!border-brand-300">
            Xabar qoldirish
          </UiButton>

          <dl class="mt-5 space-y-3.5">
            <div>
              <dt class="sr-only">Telefon</dt>
              <dd>
                <a
                  :href="PHONE_TEL"
                  class="flex items-center gap-2 whitespace-nowrap text-h3-m text-white transition-colors hover:text-brand-300 tnum md:text-h3"
                >
                  <Phone class="size-4 shrink-0 text-brand-300" aria-hidden="true" />
                  {{ PHONE_DISPLAY }}
                </a>
                <p class="mt-0.5 flex items-center gap-2 text-small text-ink-500">
                  <Clock class="size-3.5 shrink-0" aria-hidden="true" />
                  Har kuni 9:00 dan 21:00 gacha
                </p>
              </dd>
            </div>
            <div>
              <dt class="sr-only">E-mail</dt>
              <dd>
                <a
                  :href="`mailto:${EMAIL}`"
                  class="flex items-center gap-2 text-body text-white transition-colors hover:text-brand-300"
                >
                  <Mail class="size-4 shrink-0 text-brand-300" aria-hidden="true" />
                  {{ EMAIL }}
                </a>
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>

    <div class="border-t border-white/10">
      <div
        class="container-page flex flex-col gap-2 py-5 text-small text-ink-500 sm:flex-row sm:items-center sm:justify-between"
      >
        <p class="tnum">{{ year }} © Texmart — internet-do'kon</p>
        <p>Portfolio loyihasi. Hech qanday real do'kon bilan bog'liq emas.</p>
      </div>
    </div>
  </footer>
</template>
