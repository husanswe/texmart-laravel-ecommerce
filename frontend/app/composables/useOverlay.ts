import type { Ref } from 'vue'

const FOCUSABLE =
  'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'

/**
 * Shared behaviour for every overlay on the site — modal, drawer, bottom sheet,
 * mega-menu. Handles the four things each of them must get right:
 *
 *   - `Escape` closes it
 *   - focus moves in on open, is trapped inside, and returns to the trigger on close
 *   - the page behind it does not scroll
 *   - a route change closes it
 *
 * Everything is client-only; on the server the panel simply is not rendered.
 */
export function useOverlay(
  isOpen: Ref<boolean>,
  panel: Ref<HTMLElement | null>,
  close: () => void,
) {
  let previouslyFocused: HTMLElement | null = null

  function focusables(): HTMLElement[] {
    if (!panel.value) return []
    return Array.from(panel.value.querySelectorAll<HTMLElement>(FOCUSABLE)).filter(
      (el) => el.offsetParent !== null || el === document.activeElement,
    )
  }

  function onKeydown(event: KeyboardEvent) {
    if (!isOpen.value) return

    if (event.key === 'Escape') {
      event.stopPropagation()
      close()
      return
    }

    if (event.key !== 'Tab') return

    const items = focusables()
    if (items.length === 0) {
      event.preventDefault()
      return
    }

    const first = items[0]!
    const last = items[items.length - 1]!
    const active = document.activeElement

    // Wrap in both directions so focus can never escape the panel.
    if (event.shiftKey && (active === first || !panel.value?.contains(active))) {
      event.preventDefault()
      last.focus()
    } else if (!event.shiftKey && active === last) {
      event.preventDefault()
      first.focus()
    }
  }

  function lockScroll(locked: boolean) {
    if (import.meta.server) return
    document.documentElement.style.overflow = locked ? 'hidden' : ''
  }

  watch(isOpen, async (open) => {
    if (import.meta.server) return

    if (open) {
      previouslyFocused = document.activeElement as HTMLElement | null
      lockScroll(true)
      await nextTick()
      // Prefer the panel's own first control; fall back to the panel itself.
      const items = focusables()
      ;(items[0] ?? panel.value)?.focus()
    } else {
      lockScroll(false)
      previouslyFocused?.focus()
      previouslyFocused = null
    }
  })

  onMounted(() => document.addEventListener('keydown', onKeydown))
  onBeforeUnmount(() => {
    document.removeEventListener('keydown', onKeydown)
    lockScroll(false)
  })

  // Any navigation dismisses the overlay — otherwise it survives the page change.
  const router = useRouter()
  const stopAfterEach = router.afterEach(() => {
    if (isOpen.value) close()
  })
  onBeforeUnmount(stopAfterEach)
}
