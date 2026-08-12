export type ToastTone = 'success' | 'error' | 'info'

export interface Toast {
  id: number
  tone: ToastTone
  message: string
}

let nextId = 0

/**
 * Toasts are for things that happened elsewhere on the page — added to cart,
 * compare list full. Field validation never uses them; those errors belong
 * under the field.
 */
export function useToast() {
  const toasts = useState<Toast[]>('toasts', () => [])

  function dismiss(id: number) {
    toasts.value = toasts.value.filter((t) => t.id !== id)
  }

  function push(message: string, tone: ToastTone = 'success', ms = 3200) {
    const id = nextId++
    toasts.value = [...toasts.value, { id, tone, message }]
    if (import.meta.client) setTimeout(() => dismiss(id), ms)
    return id
  }

  return {
    toasts,
    push,
    dismiss,
    success: (message: string) => push(message, 'success'),
    error: (message: string) => push(message, 'error'),
    info: (message: string) => push(message, 'info'),
  }
}
