<script setup lang="ts">
import { ArrowLeft, ArrowRight } from '@lucide/vue'

interface Slide {
  eyebrow: string
  title: string
  body: string
  cta: string
  to: string
  /** Flat brand fills — no gradients. */
  surface: string
  text: string
}

const SLIDES: Slide[] = [
  {
    eyebrow: 'Muddatli to‘lov',
    title: '24 oygacha bo‘lib to‘lash',
    body: 'Boshlang‘ich to‘lovsiz, ortiqcha hujjatsiz. Faqat pasport bilan.',
    cta: 'Shartlar bilan tanishish',
    to: '/installment',
    surface: 'bg-brand-500',
    text: 'text-white',
  },
  {
    eyebrow: 'Yangi mavsum',
    title: 'Konditsionerlar 15% arzon',
    body: 'Split tizimlar o‘rnatish xizmati bilan. Kafolat 36 oy.',
    cta: 'Konditsionerlarni ko‘rish',
    to: '/c/konditsionerlar',
    surface: 'bg-brand-700',
    text: 'text-white',
  },
  {
    eyebrow: 'Har hafta',
    title: 'Maishiy texnikaga chegirmalar',
    body: 'Sovutgichlar, kir yuvish mashinalari va oshxona texnikasi.',
    cta: 'Chegirmalarni ko‘rish',
    to: '/c/sovutgichlar',
    surface: 'bg-brand-100',
    text: 'text-ink-900',
  },
]

const index = ref(0)
const paused = ref(false)

function go(next: number) {
  index.value = (next + SLIDES.length) % SLIDES.length
}

// Autoplay is a courtesy, not a requirement: it stops on hover and on focus,
// and never starts for a visitor who asked for reduced motion.
let timer: ReturnType<typeof setInterval> | null = null

onMounted(() => {
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  if (reduced) return
  timer = setInterval(() => {
    if (!paused.value) go(index.value + 1)
  }, 6000)
})

onBeforeUnmount(() => {
  if (timer) clearInterval(timer)
})

const current = computed(() => SLIDES[index.value]!)
</script>

<template>
  <section
    class="relative overflow-hidden rounded-lg border border-line"
    aria-roledescription="carousel"
    aria-label="Aksiyalar"
    @mouseenter="paused = true"
    @mouseleave="paused = false"
    @focusin="paused = true"
    @focusout="paused = false"
    @keydown.left="go(index - 1)"
    @keydown.right="go(index + 1)"
  >
    <div
      class="flex h-full min-h-[220px] flex-col justify-center p-6 transition-colors sm:min-h-[260px] sm:p-8 lg:min-h-[320px] lg:p-10"
      :class="[current.surface, current.text]"
      role="group"
      aria-roledescription="slide"
      :aria-label="`${index + 1} / ${SLIDES.length}`"
    >
      <p class="text-micro uppercase opacity-80">{{ current.eyebrow }}</p>
      <h2 class="mt-2 max-w-[18ch] text-display-m md:text-display">{{ current.title }}</h2>
      <p class="mt-3 max-w-[42ch] text-body opacity-90">{{ current.body }}</p>
      <div class="mt-6">
        <NuxtLink
          :to="current.to"
          class="inline-flex h-11 items-center rounded-md bg-surface px-5 text-body font-semibold text-ink-900 transition-colors hover:text-brand-700"
        >
          {{ current.cta }}
        </NuxtLink>
      </div>
    </div>

    <!-- Controls -->
    <button
      type="button"
      class="absolute top-1/2 left-3 grid size-10 -translate-y-1/2 place-items-center rounded-full bg-surface/90 text-ink-900 transition-colors hover:bg-surface"
      aria-label="Oldingi aksiya"
      @click="go(index - 1)"
    >
      <ArrowLeft class="size-5" aria-hidden="true" />
    </button>
    <button
      type="button"
      class="absolute top-1/2 right-3 grid size-10 -translate-y-1/2 place-items-center rounded-full bg-surface/90 text-ink-900 transition-colors hover:bg-surface"
      aria-label="Keyingi aksiya"
      @click="go(index + 1)"
    >
      <ArrowRight class="size-5" aria-hidden="true" />
    </button>

    <div class="absolute inset-x-0 bottom-4 flex justify-center gap-2">
      <button
        v-for="(slide, i) in SLIDES"
        :key="slide.title"
        type="button"
        class="h-2 rounded-full transition-all"
        :class="i === index ? 'w-6 bg-surface' : 'w-2 bg-surface/60 hover:bg-surface/90'"
        :aria-label="`${i + 1}-aksiyaga o'tish`"
        :aria-current="i === index ? 'true' : undefined"
        @click="go(i)"
      />
    </div>
  </section>
</template>
