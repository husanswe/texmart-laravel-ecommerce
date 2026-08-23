<script setup lang="ts">
import { ChevronDown } from '@lucide/vue'
import { LOCALE_OPTIONS, type Locale } from '~/stores/locale'

const locale = useLocaleStore()

const open = ref(false)
const root = ref<HTMLElement | null>(null)
const panel = ref<HTMLElement | null>(null)
const trigger = ref<HTMLElement | null>(null)
const panelId = useId()

function close() {
  open.value = false
}

function toggle() {
  open.value = !open.value
}

function choose(value: Locale) {
  locale.set(value)
  close()
  // Send focus back to the trigger so keyboard users are not dropped at the
  // top of the document when the panel unmounts.
  nextTick(() => trigger.value?.focus())
}

/** Outside click closes the panel. Bound only while it is open. */
function onPointerDown(event: PointerEvent) {
  if (!root.value?.contains(event.target as Node)) close()
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

watch(open, async (isOpen) => {
  if (import.meta.server) return
  if (isOpen) {
    document.addEventListener('pointerdown', onPointerDown)
    await nextTick()
    // Open on the selected option so the current choice is the starting point.
    panel.value?.querySelector<HTMLElement>('[aria-checked="true"]')?.focus()
  } else {
    document.removeEventListener('pointerdown', onPointerDown)
  }
})

onMounted(() => document.addEventListener('keydown', onKeydown))
onBeforeUnmount(() => {
  document.removeEventListener('keydown', onKeydown)
  document.removeEventListener('pointerdown', onPointerDown)
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

    <!-- Absolutely positioned so opening it never shifts the bar. -->
    <div
      v-if="open"
      :id="panelId"
      ref="panel"
      class="absolute top-full right-0 z-50 mt-2.5 w-52 rounded-lg border border-line bg-surface p-2 shadow-float"
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
  </div>
</template>
