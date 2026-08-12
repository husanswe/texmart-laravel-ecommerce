/** The three terms Texmart offers. */
export const INSTALLMENT_MONTHS = [6, 12, 24] as const
export type InstallmentMonths = (typeof INSTALLMENT_MONTHS)[number]

export interface InstallmentPlan {
  months: InstallmentMonths
  monthly: number
  total: number
}

/**
 * Markup applied per term. Uzbek retailers quote a monthly figure that already
 * carries the cost of the term, so a 24-month plan totals more than the sticker
 * price. These rates are what makes `716 500 × 6 oy` come out above `4 299 000 / 6`.
 */
const RATE: Record<InstallmentMonths, number> = {
  6: 1.0,
  12: 1.09,
  24: 1.2,
}

/** Monthly payment for one term, rounded up to a whole so'm. */
export function installmentFor(price: number, months: InstallmentMonths): InstallmentPlan {
  const total = Math.round(price * RATE[months])
  // Round the monthly figure to 500 so'm so the quoted number looks like a price
  // tag rather than a division result.
  const monthly = Math.ceil(total / months / 500) * 500
  return { months, monthly, total: monthly * months }
}

/** All three plans, for the product page's installment panel. */
export function installmentPlans(price: number): InstallmentPlan[] {
  return INSTALLMENT_MONTHS.map((months) => installmentFor(price, months))
}

/** The single line a product card shows: the cheapest entry term. */
export function cardInstallment(price: number): InstallmentPlan {
  return installmentFor(price, 6)
}
