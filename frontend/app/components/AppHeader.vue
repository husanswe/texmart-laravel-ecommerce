<script setup lang="ts">
import { ChevronDown, Heart, LayoutGrid, Menu, Phone, ShoppingBag, User, X } from '@lucide/vue'
import type { Category } from '~/types'

defineProps<{ categories: Category[] }>()

const cart = useCartStore()
const favorites = useFavoritesStore()

const megaOpen = ref(false)
const drawerOpen = ref(false)

/**
 * On scroll the utility bar and the category bar tuck away and the main bar
 * stays put with a shadow.
 *
 * The header is `position: fixed`, not `sticky`, and a spacer in normal flow
 * reserves its expanded height. That is deliberate: a sticky header is *in*
 * document flow, so collapsing it shrinks the page, which clamps scrollY, which
 * re-crosses the threshold — the header oscillates every frame. Fixed + a
 * constant spacer means collapsing never changes document height, so the loop
 * cannot start.
 *
 * Two more guards on top of that:
 *   - Hysteresis: collapse only above 140px, expand only below 90px. The 50px
 *     dead zone means a scrollY hovering near the threshold cannot flip-flop.
 *   - The handler is throttled to one read per animation frame.
 */
const COLLAPSE_AT = 140
const EXPAND_AT = 90

const collapsed = ref(false)
const headerEl = ref<HTMLElement | null>(null)

/**
 * Height the flow spacer reserves. Null until measured, so SSR falls back to
 * the responsive height classes on the spacer and there is no first-paint jump.
 */
const spacerHeight = ref<number | null>(null)

let ticking = false
function onScroll() {
  if (ticking) return
  ticking = true
  requestAnimationFrame(() => {
    const y = window.scrollY
    if (!collapsed.value && y > COLLAPSE_AT) collapsed.value = true
    else if (collapsed.value && y < EXPAND_AT) collapsed.value = false
    ticking = false
  })
}

/** The spacer must equal the header's *expanded* height, so only measure then. */
function measureExpanded() {
  if (!collapsed.value && headerEl.value) {
    spacerHeight.value = headerEl.value.offsetHeight
  }
}

let resizeObserver: ResizeObserver | null = null

onMounted(() => {
  onScroll()
  measureExpanded()
  window.addEventListener('scroll', onScroll, { passive: true })
  // Re-measure when the header reflows (breakpoint change, font load). The
  // observer also fires when the header collapses, but measureExpanded ignores
  // that so the reserved space stays at the expanded height.
  resizeObserver = new ResizeObserver(() => measureExpanded())
  if (headerEl.value) resizeObserver.observe(headerEl.value)
})

// Returning to expanded needs a fresh measurement, since the observer will not
// fire again if the viewport width has not changed.
watch(collapsed, (isCollapsed) => {
  if (!isCollapsed) nextTick(measureExpanded)
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', onScroll)
  resizeObserver?.disconnect()
})

const actions = computed(() => [
  { label: 'Tanlanganlar', to: '/favorites', icon: Heart, count: favorites.count },
  { label: 'Savatcha', to: '/cart', icon: ShoppingBag, count: cart.count },
  { label: 'Mening profilim', to: '/cabinet', icon: User, count: 0 },
])
</script>

<template>
  <header
    ref="headerEl"
    class="fixed inset-x-0 top-0 z-40 bg-surface"
    :class="collapsed && 'shadow-raise'"
  >
    <!-- ── Row 1 — utility bar ─────────────────────────────────────────── -->
    <div
      class="hidden overflow-hidden border-b border-line bg-canvas transition-[max-height] md:block"
      :class="collapsed ? 'max-h-0' : 'max-h-12'"
    >
      <div class="container-page flex h-11 items-center justify-end gap-6">
        <div class="flex items-center gap-5">
          <a
            href="tel:+998712307799"
            class="flex items-center gap-1.5 text-small text-ink-700 transition-colors hover:text-brand-700 tnum"
          >
            <Phone class="size-4" aria-hidden="true" />
            71 230 77 99
          </a>
          <button
            type="button"
            class="flex items-center gap-1.5 text-small text-ink-500 transition-colors hover:text-brand-700"
          >
            O'zbekcha
            <ChevronDown class="size-3.5" aria-hidden="true" />
          </button>
        </div>
      </div>
    </div>

    <!-- ── Row 2 — main bar ────────────────────────────────────────────── -->
    <div class="border-b border-line">
      <div class="container-page flex h-16 items-center gap-3 md:h-[72px] md:gap-5">
        <!-- Mobile: menu trigger -->
        <button
          type="button"
          class="-ml-2 grid size-10 shrink-0 place-items-center rounded-md text-ink-700 transition-colors hover:bg-canvas lg:hidden"
          aria-label="Menyuni ochish"
          @click="drawerOpen = true"
        >
          <Menu class="size-6" aria-hidden="true" />
        </button>

        <NuxtLink to="/" class="shrink-0" aria-label="Texmart — bosh sahifa">
          <TexmartLogo />
        </NuxtLink>

        <!-- Catalog button — filled, prominent. The wrapper carries the
             breakpoint: `hidden` on the button itself loses to the component's
             own `inline-flex`, since Tailwind resolves by stylesheet order. -->
        <div class="hidden shrink-0 lg:block">
          <UiButton size="lg" :aria-expanded="megaOpen" @click="megaOpen = !megaOpen">
            <template #icon>
              <component :is="megaOpen ? X : LayoutGrid" class="size-5" aria-hidden="true" />
            </template>
            Mahsulotlar katalogi
          </UiButton>
        </div>

        <!-- Search — the defining element of the bar -->
        <div class="hidden min-w-0 flex-1 md:block">
          <SearchBar />
        </div>

        <!-- Icon-above-label actions -->
        <nav class="ml-auto flex shrink-0 items-center gap-1 sm:gap-2" aria-label="Foydalanuvchi">
          <NuxtLink
            v-for="action in actions"
            :key="action.label"
            :to="action.to"
            class="relative flex w-11 flex-col items-center gap-1 rounded-md py-1.5 text-ink-700 transition-colors hover:text-brand-600 xl:w-[72px]"
            :class="action.label === 'Mening profilim' ? '' : 'hidden sm:flex'"
          >
            <span class="relative">
              <component :is="action.icon" class="size-6" aria-hidden="true" />
              <span
                v-if="action.count > 0"
                class="absolute -top-1.5 -right-2 grid h-[18px] min-w-[18px] place-items-center rounded-full bg-brand-500 px-1 text-[11px] leading-none font-semibold text-white tnum"
              >
                {{ action.count }}
              </span>
            </span>
            <!-- Labels appear only from xl; between lg and xl they would steal
                 the width the search bar needs to stay the prominent element. -->
            <span class="hidden text-[11px] leading-tight xl:block">{{ action.label }}</span>
            <span class="sr-only xl:hidden">{{ action.label }}</span>
          </NuxtLink>
        </nav>
      </div>

      <!-- Mobile search sits on its own line so the bar above stays uncrowded -->
      <div class="container-page pb-3 md:hidden">
        <SearchBar size="md" />
      </div>
    </div>

    <!-- ── Row 3 — category bar ────────────────────────────────────────── -->
    <div
      class="hidden overflow-hidden border-b border-line bg-surface transition-[max-height] lg:block"
      :class="collapsed ? 'max-h-0' : 'max-h-14'"
    >
      <div class="container-page">
        <nav aria-label="Kategoriyalar">
          <ul class="flex h-12 items-center gap-1 overflow-x-auto">
            <li v-for="category in categories" :key="category.id" class="shrink-0">
              <NuxtLink
                :to="`/c/${category.slug}`"
                class="block rounded-md px-3 py-1.5 text-small whitespace-nowrap text-ink-700 transition-colors hover:bg-canvas hover:text-brand-700"
              >
                {{ category.name }}
              </NuxtLink>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <MegaMenu v-model="megaOpen" :categories="categories" />

    <!-- ── Mobile drawer ───────────────────────────────────────────────── -->
    <UiDrawer v-model="drawerOpen" title="Mahsulotlar katalogi">
      <nav aria-label="Kategoriyalar">
        <ul class="space-y-0.5">
          <li v-for="category in categories" :key="category.id">
            <NuxtLink
              :to="`/c/${category.slug}`"
              class="flex items-center gap-3 rounded-md px-3 py-2.5 text-body text-ink-700 transition-colors hover:bg-canvas"
            >
              <CategoryIcon :name="category.icon" class="size-5 shrink-0 text-brand-500" />
              <span class="min-w-0 flex-1 truncate">{{ category.name }}</span>
              <span class="shrink-0 text-small text-ink-300 tnum">{{ category.productCount }}</span>
            </NuxtLink>
          </li>
        </ul>
      </nav>

      <template #footer>
        <a href="tel:+998712307799" class="flex items-center gap-2 text-body text-ink-700 tnum">
          <Phone class="size-4 text-brand-500" aria-hidden="true" />
          71 230 77 99
        </a>
      </template>
    </UiDrawer>
  </header>

  <!-- Flow spacer that reserves the header's expanded height. Because the header
       is fixed (out of flow) and this height is constant while scrolled, the
       document height never changes when the header collapses. The responsive
       classes are the SSR fallback (mobile / md / lg expanded totals); once
       mounted, the measured height takes over. -->
  <div
    aria-hidden="true"
    class="h-[121px] shrink-0 md:h-[118px] lg:h-[167px]"
    :style="spacerHeight != null ? { height: `${spacerHeight}px` } : undefined"
  />
</template>
