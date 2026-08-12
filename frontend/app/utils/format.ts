/**
 * Formatting helpers. Prices are formatted here and nowhere else — never inline
 * in a template — so that every so'm figure on the site groups its digits the
 * same way.
 */

/** A narrow no-break space (U+202F): the thousands separator used site-wide. */
const NNBSP = ' '

/**
 * Format an integer so'm amount: `2399000` → `2 399 000 so'm`.
 *
 * Grouping uses a narrow no-break space so a price never wraps mid-number.
 * Pass `withSuffix: false` for contexts that print the unit themselves, such as
 * a range input or a table column already headed "so'm".
 */
export function formatSum(value: number, options: { withSuffix?: boolean } = {}): string {
  const { withSuffix = true } = options
  const rounded = Math.round(Number.isFinite(value) ? value : 0)
  const sign = rounded < 0 ? '-' : ''
  const digits = Math.abs(rounded).toString()

  let grouped = ''
  for (let i = 0; i < digits.length; i++) {
    // Insert a separator before every group of three, counted from the right.
    if (i > 0 && (digits.length - i) % 3 === 0) grouped += NNBSP
    grouped += digits[i]
  }

  return `${sign}${grouped}${withSuffix ? ` so'm` : ''}`
}

/** Format a plain integer with the same grouping but no unit: `1240` → `1 240`. */
export function formatNumber(value: number): string {
  return formatSum(value, { withSuffix: false })
}

/**
 * Format a discount as a negative percentage chip: `(4299000, 4999000)` → `-14%`.
 * Returns null when there is no genuine discount, so callers can skip the badge.
 */
export function formatDiscount(price: number, oldPrice?: number): string | null {
  if (!oldPrice || oldPrice <= price) return null
  return `-${Math.round(((oldPrice - price) / oldPrice) * 100)}%`
}

const MONTHS_UZ = [
  'yanvar',
  'fevral',
  'mart',
  'aprel',
  'may',
  'iyun',
  'iyul',
  'avgust',
  'sentabr',
  'oktabr',
  'noyabr',
  'dekabr',
]

/** Format an ISO date as `15 avgust 2026`. */
export function formatDate(iso: string): string {
  const date = new Date(iso)
  if (Number.isNaN(date.getTime())) return iso
  return `${date.getDate()} ${MONTHS_UZ[date.getMonth()]} ${date.getFullYear()}`
}

/**
 * Format a 12-digit Uzbek number for display: `998998856458` → `+998 99 885-64-58`.
 * Anything that is not 12 digits is returned unchanged rather than mangled.
 */
export function formatPhone(raw: string): string {
  const digits = raw.replace(/\D/g, '')
  if (digits.length !== 12) return raw
  return `+${digits.slice(0, 3)} ${digits.slice(3, 5)} ${digits.slice(5, 8)}-${digits.slice(8, 10)}-${digits.slice(10)}`
}

/** Join a product's short specs into the single meta line a card shows. */
export function joinSpecs(specs: { label: string; value: string }[], max = 4): string {
  return specs
    .slice(0, max)
    .map((s) => s.value)
    .join(' · ')
}
