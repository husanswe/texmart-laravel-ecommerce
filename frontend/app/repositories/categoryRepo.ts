import type { Brand, Category } from '~/types'
import categoriesFixture from '~/data/categories.json'
import brandsFixture from '~/data/brands.json'

const categories = categoriesFixture as Category[]
const brands = brandsFixture as Brand[]

/** The full category tree — top-level categories each carrying their children. */
export async function listCategories(): Promise<Category[]> {
  if (usingMocks()) return categories
  return useApi<Category[]>('/categories')
}

/** One category by slug, matching either a top-level entry or a child. */
export async function getCategory(slug: string): Promise<Category | null> {
  if (usingMocks()) {
    for (const parent of categories) {
      if (parent.slug === slug) return parent
      const child = parent.children?.find((c) => c.slug === slug)
      if (child) return child
    }
    return null
  }
  return useApi<Category>(`/categories/${slug}`)
}

/** Every category flattened, parents first — used by breadcrumbs and filters. */
export function flattenCategories(tree: Category[]): Category[] {
  return tree.flatMap((parent) => [parent, ...(parent.children ?? [])])
}

export async function listBrands(): Promise<Brand[]> {
  if (usingMocks()) return brands
  return useApi<Brand[]>('/brands')
}
