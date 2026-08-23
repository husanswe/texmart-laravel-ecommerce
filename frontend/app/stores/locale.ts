import { defineStore } from 'pinia'

export type Locale = 'uz' | 'ru'

export interface LocaleOption {
  value: Locale
  label: string
}

/** Order matches the switcher panel: Russian first, then Uzbek, as on idea.uz. */
export const LOCALE_OPTIONS: LocaleOption[] = [
  { value: 'ru', label: 'Русский' },
  { value: 'uz', label: "O'zbekcha" },
]

/**
 * The interface language. Content translation itself is the backend's job
 * (spatie/laravel-translatable); this store is only the chosen locale plus the
 * value `useApi` forwards to the API so it returns the right language.
 *
 * It defaults to 'uz' and stays 'uz' through SSR and hydration; the persistence
 * plugin rehydrates the saved choice after mount, so the server and first
 * client render agree and there is no hydration mismatch.
 */
export const useLocaleStore = defineStore('locale', () => {
  const current = ref<Locale>('uz')

  const label = computed(
    () => LOCALE_OPTIONS.find((o) => o.value === current.value)?.label ?? "O'zbekcha",
  )

  function set(locale: Locale) {
    current.value = locale
  }

  function hydrate(saved: Locale) {
    if (saved === 'uz' || saved === 'ru') current.value = saved
  }

  return { current, label, set, hydrate }
})
