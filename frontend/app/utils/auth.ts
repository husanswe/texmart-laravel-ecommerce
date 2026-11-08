/**
 * Accepts "90 123 45 67", "998901234567" or "+998 90 123 45 67" and returns
 * "+998901234567" — the format the users table stores.
 */
export function normalizePhone(input: string): string {
  const digits = input.replace(/\D/g, '')
  if (digits.length === 9) return `+998${digits}`
  if (digits.length === 12 && digits.startsWith('998')) return `+${digits}`
  return input.trim()
}

/** Turns a Laravel error response (422 validation, 401, 429...) into one readable line. */
export function apiErrorMessage(e: any): string {
  const data = e?.data
  if (data?.errors) {
    const first = Object.values(data.errors as Record<string, string[]>).flat()[0]
    if (first) return first
  }
  if (e?.response?.status === 429) return "Juda ko'p urinish. Birozdan so'ng qayta urinib ko'ring."
  return data?.message ?? "Xatolik yuz berdi. Qayta urinib ko'ring."
}