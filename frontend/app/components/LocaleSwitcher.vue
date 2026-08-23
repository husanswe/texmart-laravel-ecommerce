<script setup lang="ts">
import { ChevronDown } from '@lucide/vue'
import { LOCALE_OPTIONS, type Locale } from '~/stores/locale'

const locale = useLocaleStore()

const open = ref(false)
const root = ref<HTMLElement | null>(null)
const panel = ref<HTMLElement | null>(null)
const trigger = ref<HTMLElement | null>(null)
const panelId = useId()

/**
 * The panel is teleported to <body> and positioned fixed, rather than being an
 * absolutely-positioned child of the switcher.
 *
 * It has to be: the utility bar it sits in is `overflow-hidden` with a capped
 * max-height, because that is how the bar collapses on scroll. A panel rendered
 * inside it gets clipped to ~45px — and since an overflow-hidden box is also a
 * scroll container, focusing an option scrolled the panel up out of sight, so
 * only the last row remained visible. Teleporting escapes both problems.
 */
const panelPos = ref<{ top: number; right: number }>({ top: 0, right: 0 })

function updatePosition() {
  const el = trigger.value
  if (!el) return
  const r = el.getBoundingClientRect()
  // clientWidth, not innerWidth: a fixed element's `right` resolves against the
  // viewport excluding the scrollbar, so innerWidth would offset the panel by
  // the scrollbar's width (15px here).
  const viewportWidth = document.documentElement.clientWidth
  panelPos.value = {
    top: r.bottom + 10,
    // Right-aligned to the trigger.
    right: Math.max(8, viewportWidth - r.right),
  }
}

function close() {
  open.value = false
}

function toggle() {
  if (!open.value) updatePosition()
  open.value = !open.value
}

function choose(value: Locale) {
  locale.set(value)
  close()
  // Send focus back to the trigger so keyboard users are not dropped at the
  // top of the document when the panel unmounts.
  nextTick(() => trigger.value?.focus())
}

/**
 * Outside click closes the panel. Bound only while it is open.
 *
 * The panel is teleported to <body>, so it is NOT inside `root` — it has to be
 * tested separately. Checking only `root` would treat a press on an option as
 * an outside click, closing the panel on pointerdown and unmounting the button
 * before its click could fire, so choosing a language would do nothing.
 */
function onPointerDown(event: PointerEvent) {
  const target = event.target as Node
  if (root.value?.contains(target) || panel.value?.contains(target)) return
  close()
}

function onKeydown(event: KeyboardEvent) {
  if (event.key === 'Escape' && open.value) {
    close()
    trigger.value?.focus()
    return
  }
  // Arrow keys move between the two options once inside the panel.
  if (!open.value || !['ArrowDown', 'ArrowUp'].includes(event.key)) return
  const items = Array.from(panel.value?.querySelectorAll<HTMLElement>('[role="radio"]') ?? [])
  if (items.length === 0) return
  event.preventDefault()
  const index = items.indexOf(document.activeElement as HTMLElement)
  const next =
    event.key === 'ArrowDown'
      ? index >= items.length - 1
        ? 0
        : index + 1
      : index <= 0
        ? items.length - 1
        : index - 1
  items[next]?.focus()
}

/** Scrolling collapses the utility bar, taking the trigger with it. */
function onScroll() {
  if (open.value) close()
}

function onResize() {
  if (open.value) updatePosition()
}

watch(open, async (isOpen) => {
  if (import.meta.server) return
  if (isOpen) {
    document.addEventListener('pointerdown', onPointerDown)
    window.addEventListener('scroll', onScroll, { passive: true })
    window.addEventListener('resize', onResize)
    await nextTick()
    // Open on the selected option so the current choice is the starting point.
    // Safe now the panel is teleported: focusing it can no longer scroll a
    // clipping ancestor, because it no longer has one.
    panel.value?.querySelector<HTMLElement>('[aria-checked="true"]')?.focus()
  } else {
    document.removeEventListener('pointerdown', onPointerDown)
    window.removeEventListener('scroll', onScroll)
    window.removeEventListener('resize', onResize)
  }
})

onMounted(() => document.addEventListener('keydown', onKeydown))
onBeforeUnmount(() => {
  document.removeEventListener('keydown', onKeydown)
  document.removeEventListener('pointerdown', onPointerDown)
  window.removeEventListener('scroll', onScroll)
  window.removeEventListener('resize', onResize)
})

// A route change must not leave the panel hanging open.
const router = useRouter()
const stopAfterEach = router.afterEach(() => close())
onBeforeUnmount(stopAfterEach)
</script>

<template>
  <div ref="root" class="relative">
    <button
      ref="trigger"
      type="button"
      class="flex items-center gap-1.5 rounded-md text-small text-ink-500 transition-colors hover:text-brand-700"
      aria-haspopup="true"
      :aria-expanded="open"
      :aria-controls="open ? panelId : undefined"
      @click="toggle"
    >
      <FlagIcon :locale="locale.current" class="h-3.5 w-5" />
      <span class="whitespace-nowrap">{{ locale.label }}</span>
      <ChevronDown
        class="size-3.5 transition-transform"
        :class="open && 'rotate-180'"
        aria-hidden="true"
      />
    </button>

    <!-- Teleported out of the clipping utility bar; fixed, so opening it never
         shifts the bar either. -->
    <Teleport to="body">
      <div
        v-if="open"
        :id="panelId"
        ref="panel"
        class="fixed z-[60] w-52 rounded-lg border border-line bg-surface p-2 shadow-float"
        :style="{ top: `${panelPos.top}px`, right: `${panelPos.right}px` }"
        role="radiogroup"
        aria-label="Tilni tanlang"
      >
        <!-- Caret connecting the panel to the button -->
        <span
          class="absolute -top-[6px] right-5 size-3 rotate-45 border-t border-l border-line bg-surface"
          aria-hidden="true"
        />

        <p class="px-2 pt-1 pb-2 text-small font-semibold text-ink-900">Tilni tanlang</p>

        <button
          v-for="option in LOCALE_OPTIONS"
          :key="option.value"
          type="button"
          role="radio"
          :aria-checked="locale.current === option.value"
          class="flex w-full items-center gap-2.5 rounded-md px-2 py-2 text-left text-body transition-colors hover:bg-canvas"
          :class="locale.current === option.value ? 'text-ink-900' : 'text-ink-700'"
          @click="choose(option.value)"
        >
          <FlagIcon :locale="option.value" class="h-4 w-6" />
          <span class="min-w-0 flex-1 truncate">{{ option.label }}</span>
          <span
            class="grid size-[18px] shrink-0 place-items-center rounded-full border transition-colors"
            :class="locale.current === option.value ? 'border-brand-500' : 'border-line'"
            aria-hidden="true"
          >
            <span
              v-if="locale.current === option.value"
              class="size-2.5 rounded-full bg-brand-500"
            />
          </span>
        </button>
      </div>
    </Teleport>
  </div>
</template>
