/**
 * Shared domain types. These mirror the Laravel API resources, so switching
 * `useMocks` off changes nothing here.
 */

/** Integer so'm. Never a float — money is counted, not measured. */
export type Money = number

export interface Category {
  id: number
  slug: string
  name: string
  parentId: number | null
  /** Lucide icon name, resolved by CategoryIcon.vue. */
  icon: string
  productCount: number
  children?: Category[]
}

export interface Brand {
  id: number
  slug: string
  name: string
}

export interface AttributeValue {
  attributeId: number
  attributeName: string
  group: string
  value: string
  unit?: string
}

export interface Variant {
  id: number
  sku: string
  label: string
  color?: string
  storage?: string
  price: Money
  oldPrice?: Money
  stock: number
}

export interface ShortSpec {
  label: string
  value: string
}

export interface Product {
  id: number
  slug: string
  name: string
  code: string
  brand: Brand
  categoryId: number
  price: Money
  oldPrice?: Money
  images: string[]
  variants: Variant[]
  attributes: AttributeValue[]
  rating: number
  reviewCount: number
  inStock: boolean
  warrantyMonths: number
  /** Max 4 — the meta line on a card and the summary on the product page. */
  shortSpecs: ShortSpec[]
  /** Drives the XIT badge and the "Sotuvlar xiti" row. */
  isHit?: boolean
  /** ISO date, used by the "Yangi kelganlar" row and `newest` sorting. */
  createdAt: string
}

export interface CartLine {
  productId: number
  variantId: number
  qty: number
}

export interface Paginated<T> {
  data: T[]
  meta: {
    total: number
    currentPage: number
    lastPage: number
    perPage: number
  }
}

export type SortKey = 'popular' | 'price_asc' | 'price_desc' | 'newest' | 'rating'

/** Query shape matching the API's `/products` parameters exactly. */
export interface ProductQuery {
  category?: string
  brand?: string[]
  attr?: Record<string, string[]>
  priceMin?: number
  priceMax?: number
  inStock?: boolean
  discounted?: boolean
  hit?: boolean
  q?: string
  sort?: SortKey
  page?: number
  perPage?: number
}
