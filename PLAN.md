# Texmart frontend — build plan

Source of truth: `FRONTEND_PRD.md`. This document is the *how*: folder layout, component tree, token block, build order, and the decisions I need signed off before any code is written.

Nothing has been built yet. This repo currently contains this file and an empty git history.

---

## 0. Decisions I need from you

Four items. Everything else in this plan follows the PRD literally.

**0.1 — Where this is committed.** Your kickoff message said commit to `husanswe/texmart-laravel-ecommerce`; when I asked, you chose a separate frontend repo. Those conflict. The repo currently holds only `LICENSE` and `README.md`, so either is still cheap. My read: a separate repo is the right call *if* you want the Laravel API judged on its own; but the backend PRD assumes one repo (`docker-compose.yml` at the root, both apps deployed from it), so a monorepo tells a more complete story to a hiring manager.

Local work happens in `C:\Users\User\Desktop\texmart-frontend` regardless. Tell me one of:
- **a)** Create `husanswe/texmart-nuxt-frontend` and push there. I will not create a GitHub repo without your explicit go-ahead on the name.
- **b)** Push into `texmart-laravel-ecommerce` after all — I would then move the app under `frontend/` and keep the root free for `backend/` and `docker-compose.yml`.

**0.2 — Home page top strip.** You chose three static banner tiles over the PRD's two promo panels. To avoid two promo blocks saying the same thing, I plan to *merge* them: the three tiles carry the PRD's copy, and PRD §4.1 item 2 is dropped rather than duplicated.

| Tile | Copy | Surface |
|---|---|---|
| 1 (wide, 6 cols) | `Muddatli to'lov — 24 oygacha` · `Boshlang'ich to'lovsiz` | `brand-50` |
| 2 (3 cols) | `Yangi kelganlar` | `canvas` + 1px line |
| 3 (3 cols) | `Maxsus narxlar` | `install-bg` |

Flat fills, ink text, one arrow link each. No images, no gradients, no rotation, no auto-advance. On mobile they stack; tile 1 keeps its height, tiles 2–3 halve. Home order becomes: **banner tiles → category rail → Yangi kelganlar → Chegirmadagi → brand strip → trust row.** Say if you want the category rail first instead.

**0.3 — Product imagery.** There are no real product photos and the PRD bans stock-photo-looking placeholders. Plan: a build script generates one flat SVG per product into `public/img/products/<code>.svg` — `canvas` fill, 1px `line` border, the model code centred in 12px JetBrains Mono. Real files, so `<NuxtImg>` gets genuine `width`/`height`, `alt`, and lazy loading, and swapping in real photos later is a path change in the fixtures and nothing else. Consequence to accept: the category tiles' "photo bleeding out of the bottom-right corner" bleeds a placeholder. If you would rather I source real product images, say so now — it changes Phase 2.

**0.4 — Weight 650.** The PRD asks for `650` on `h2`. That only renders as 650 with a variable font; a static-weight Inter will snap to 600 or 700. I will load Inter as a variable font (weight range 400–700) via `@nuxt/fonts` so 650 is real. Flagging it because it costs one extra font file.

---

## 1. Stack, pinned

Verified against npm today, all versions exist:

| Package | Pin | Latest available |
|---|---|---|
| `nuxt` | `^4.5.1` | 4.5.2 |
| `tailwindcss` | `^4.3.3` | 4.3.3 |
| `@tailwindcss/vite` | `^4.3.3` | 4.3.3 |
| `@pinia/nuxt` + `pinia` | `^1.0.2` / `^4.0.3` | same |
| `@nuxt/image` | `^2.1.0` | 2.1.0 |
| `@nuxt/fonts` | `^0.14.0` | 0.14.0 |
| `lucide-vue-next` | `^1.0.0` | 1.0.0 |

Node 22.19.0 is installed. pnpm is **not** — I will enable it with `corepack enable pnpm` as the first step of Phase 1 and pin it via `packageManager` in `package.json`.

`ssr: true`. `typescript.strict: true` and `typescript.typeCheck: true` so `pnpm build` fails on a type error rather than warning. No `tailwind.config.js` — theme lives in `app/assets/css/main.css`.

---

## 2. Folder structure

Nuxt 4's `srcDir` is `app/`, which lines up exactly with the paths the PRD names.

```
texmart-frontend/
├── app/
│   ├── app.vue
│   ├── error.vue                     # 404 / 500 shell
│   ├── assets/css/main.css           # @import tailwindcss + @theme + base + utilities
│   ├── components/
│   │   ├── ui/                       # primitives → <UiButton>, <UiModal>, …
│   │   └── *.vue                     # domain → <ProductCard>, <CompareTray>, …
│   ├── composables/
│   │   ├── useApi.ts                 # the only $fetch in the codebase
│   │   ├── useCatalogQuery.ts        # URL query ⇄ filter state
│   │   ├── useMediaQuery.ts
│   │   └── useToast.ts
│   ├── data/                         # JSON fixtures
│   │   ├── categories.json  brands.json  attributes.json
│   │   ├── products.json    stores.json  orders.json  reviews.json
│   ├── layouts/
│   │   ├── default.vue               # header + main + footer + tab bar + compare tray
│   │   └── auth.vue                  # centred card, wordmark only
│   ├── middleware/auth.ts            # guards /cabinet/*
│   ├── pages/                        # §4 routes, 1:1
│   ├── plugins/persist.client.ts     # localStorage rehydrate, client only
│   ├── repositories/
│   │   ├── productRepo.ts  categoryRepo.ts  orderRepo.ts  authRepo.ts
│   │   └── mock/                     # filter, sort, paginate, facet-count engine
│   ├── stores/                       # cart compare favorites auth ui
│   ├── types/index.ts                # §3.1 verbatim + query/response types
│   └── utils/
│       ├── format.ts                 # formatSum, formatDate, formatPhone
│       └── installment.ts            # 6 / 12 / 24 oy plans
├── public/img/products/*.svg         # generated
├── scripts/generate-placeholders.mjs
├── nuxt.config.ts
├── .env.example                      # NUXT_PUBLIC_API_BASE, NUXT_PUBLIC_USE_MOCKS
├── PLAN.md
└── README.md
```

Auto-import naming: `components/ui/Button.vue` → `<UiButton>`; domain components keep their own name. Pinia is pointed at `./app/stores/**` explicitly, since Nuxt 4's default differs.

---

## 3. The `@theme` block

This is the exact block that will land in `app/assets/css/main.css`. Colors, radii and shadows are copied from the PRD unchanged; the type scale is encoded as Tailwind v4 `--text-*` tokens so line-height, weight and tracking travel with the size instead of being reapplied by hand at every call site. `-m` suffix = mobile step, used as `text-display-m md:text-display`.

```css
@import "tailwindcss";

@theme {
  /* ── Brand — Dodger blue ─────────────────────────────── */
  --color-brand-50:  #EAF4FF;
  --color-brand-100: #D2E7FF;
  --color-brand-300: #7CBCFF;
  --color-brand-500: #1E90FF;   /* primary */
  --color-brand-600: #0B76E0;   /* hover */
  --color-brand-700: #0A5FB4;   /* active / links on light */

  /* ── Ink — never pure black ──────────────────────────── */
  --color-ink-900: #0E1726;
  --color-ink-700: #26364F;
  --color-ink-500: #5B6B82;
  --color-ink-300: #98A5B8;

  /* ── Surface ─────────────────────────────────────────── */
  --color-surface: #FFFFFF;
  --color-canvas:  #F5F7FA;
  --color-line:    #E3E8EF;

  /* ── Semantic — used sparingly ───────────────────────── */
  --color-stock:      #0E9F6E;
  --color-out:        #C6304A;
  --color-install:    #B45309;
  --color-install-bg: #FEF6E7;

  /* ── Type ────────────────────────────────────────────── */
  --font-sans: "Inter", ui-sans-serif, system-ui, sans-serif;
  --font-mono: "JetBrains Mono", ui-monospace, monospace;

  --text-display: 34px;
  --text-display--line-height: 40px;
  --text-display--font-weight: 700;
  --text-display--letter-spacing: -0.025em;
  --text-display-m: 26px;
  --text-display-m--line-height: 32px;
  --text-display-m--font-weight: 700;
  --text-display-m--letter-spacing: -0.025em;

  --text-h2: 24px;
  --text-h2--line-height: 30px;
  --text-h2--font-weight: 650;
  --text-h2--letter-spacing: -0.02em;
  --text-h2-m: 20px;
  --text-h2-m--line-height: 26px;
  --text-h2-m--font-weight: 650;
  --text-h2-m--letter-spacing: -0.02em;

  --text-h3: 17px;
  --text-h3--line-height: 24px;
  --text-h3--font-weight: 600;
  --text-h3--letter-spacing: -0.01em;
  --text-h3-m: 16px;
  --text-h3-m--line-height: 22px;
  --text-h3-m--font-weight: 600;
  --text-h3-m--letter-spacing: -0.01em;

  --text-body: 15px;
  --text-body--line-height: 24px;
  --text-body--font-weight: 400;

  --text-small: 13px;
  --text-small--line-height: 18px;
  --text-small--font-weight: 500;

  --text-micro: 11px;
  --text-micro--line-height: 14px;
  --text-micro--font-weight: 600;
  --text-micro--letter-spacing: 0.04em;

  --text-price: 20px;
  --text-price--line-height: 26px;
  --text-price--font-weight: 700;
  --text-price--letter-spacing: -0.01em;
  --text-price-m: 18px;
  --text-price-m--line-height: 24px;
  --text-price-m--font-weight: 700;
  --text-price-m--letter-spacing: -0.01em;

  --text-price-lg: 32px;
  --text-price-lg--line-height: 38px;
  --text-price-lg--font-weight: 700;
  --text-price-lg--letter-spacing: -0.02em;
  --text-price-lg-m: 26px;
  --text-price-lg-m--line-height: 32px;
  --text-price-lg-m--font-weight: 700;
  --text-price-lg-m--letter-spacing: -0.02em;

  /* ── Radius ──────────────────────────────────────────── */
  --radius-sm: 6px;    /* badges, chips, checkboxes */
  --radius-md: 10px;   /* buttons, inputs, selects */
  --radius-lg: 14px;   /* cards, panels, modals */

  /* ── Shadow — these three and nothing else ───────────── */
  --shadow-raise: 0 1px 2px rgb(14 23 38 / 0.05);
  --shadow-hover: 0 6px 20px rgb(14 23 38 / 0.08);
  --shadow-float: 0 12px 32px rgb(14 23 38 / 0.12);

  /* ── Motion — one duration for the whole site ────────── */
  --default-transition-duration: 160ms;
  --default-transition-timing-function: cubic-bezier(0.2, 0, 0, 1);
  --ease-brand: cubic-bezier(0.2, 0, 0, 1);

  /* ── Layout ──────────────────────────────────────────── */
  --container-page: 1280px;   /* max-w-page */
  --spacing-section: 56px;    /* py-section desktop */
  --spacing-section-m: 40px;  /* py-section-m mobile */
  --spacing-sidebar: 264px;   /* w-sidebar */
}
```

Alongside it, in the same file:

```css
@utility tnum { font-variant-numeric: tabular-nums; }

@layer base {
  html { background: var(--color-canvas); color: var(--color-ink-700); }
  :focus-visible { outline: 2px solid var(--color-brand-500); outline-offset: 2px; }
}

@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
```

Breakpoints stay Tailwind defaults (`sm 640 / md 768 / lg 1024 / xl 1280`).

---

## 4. Component tree

```
layouts/default.vue
├── AppHeader
│   ├── [row 1] utility bar — Aksiyalar · Do'konlar · tel · til   (hidden < md)
│   ├── [row 2] TexmartWordmark · MegaMenu trigger · SearchAutocomplete
│   │           · HeaderAction ×4 (Sevimlilar / Savatcha / Taqqoslash / Profil)
│   ├── [row 3] 8 top-level category links                        (hidden < md)
│   ├── MegaMenu            — click-open, focus-trapped, Esc closes
│   └── MobileDrawer        — < md
├── <slot />
├── AppFooter               — 4 columns + contact, ink-900
├── MobileTabBar            — < md, 56px, safe-area
├── CompareTray             — fixed bottom, ≥ 2 items, sits above MobileTabBar
└── ToastHost

ProductCard
├── UiBadge (-15% / Sotuvda yo'q)
├── IconButton ×2 (favorite, compare)   aria-pressed
├── NuxtImg 1:1
├── title (2-line clamp, fixed 44px) · shortSpecs · PriceBlock
└── UiButton "Savatga"  |  outline "Xabar berish" when out of stock

PriceBlock          price · oldPrice strike · installment line (amber, .tnum)
InstallmentPanel    UiTabs 6/12/24 oy → monthly × N + total
FilterSidebar       PriceRangeFilter · FilterFacet[] · toggles · sticky "Tozalash"
CompareTable        sticky header row · grouped spec rows · differences-only toggle
```

**UI primitives** (Phase 1, all typed, no `any`): `Button` (primary / secondary / ghost / danger × sm / md / lg × loading / disabled), `Input`, `Select`, `Checkbox`, `Radio`, `Chip`, `Badge`, `Modal`, `Drawer`, `BottomSheet`, `Tabs`, `Accordion`, `Skeleton`, `Pagination`, `Rating`, `QtyStepper`, `Breadcrumb`, `EmptyState`, `Toast`.

**Stores:** `cart`, `compare` (max 4, toast on the 5th), `favorites`, `auth`, `ui`. The first three persist to `localStorage` and rehydrate from a `.client` plugin *after* mount, so the server and first client render agree — no hydration mismatch.

---

## 5. Data layer

```ts
// app/repositories/productRepo.ts
export async function listProducts(params: ProductQuery): Promise<Paginated<Product>> {
  if (useRuntimeConfig().public.useMocks) return mockList(params)
  return useApi<Paginated<Product>>('/products', { query: params })
}
```

Pages and components never touch `$fetch`. The mock branch does real work — filtering, sorting, pagination *and* per-facet counts computed with the other filters applied — so the catalog is fully interactive with no backend, and the response shape matches the backend PRD's `data` / `meta` / `filters` envelope. Query keys mirror it too (`category`, `brand[]`, `attr[ram][]`, `price_min`, `price_max`, `in_stock`, `sort`, `page`, `per_page`), so the live swap is `NUXT_PUBLIC_USE_MOCKS=false` and nothing else.

**Fixtures:** 8 top-level categories (3–5 children each), 14 brands, 60 products with real spec sets per category and so'm prices from 149 000 to 24 999 000. Audio gets 2 products to exercise the sparse state; 6 out of stock, 8 discounted, 5 with multiple variants.

---

## 6. Build order

Each phase ends with `pnpm build` clean — zero errors, zero Vue warnings — screenshots at 360px and 1280px, my own critique against the PRD, and a stop for your review. Commits are small and imperative, pushed as each phase lands.

| Phase | Contents | Gate |
|---|---|---|
| 1 | Nuxt + Tailwind + fonts, `@theme`, `formatSum`, all 20 primitives, `/styleguide` | You review the styleguide before any page exists |
| 2 | Types, fixtures, placeholder generation, repositories, `useApi`, mock/live switch | Catalog data queryable in isolation |
| 3 | Header, mega-menu, search autocomplete, footer, mobile tab bar, layouts | Chrome works keyboard-only |
| 4 | `ProductCard`, `ProductGrid`, home page | Grid is flush at every breakpoint |
| 5 | Category page — filters, URL state, sort, pagination, empty + loading | Filters survive refresh and back/forward |
| 6 | Product detail — gallery, variants, installment panel, spec tabs, JSON-LD | |
| 7 | Compare tray + table + differences-only. The signature screen | Works with 2, 3 and 4 products |
| 8 | Cart, checkout (3 steps), cabinet, auth | |
| 9 | Responsive / keyboard / reduced-motion audits, Lighthouse, README | §8 checklist fully ticked |

Verification is not left to Phase 9 — each phase is audited at 360px as it lands, because a layout fixed at the end is a layout rebuilt at the end.

---

## 7. Risks I am tracking

- **Facet counts with mock data.** Counting must exclude the facet's own filter or every option reads as its own count. Cheap to get subtly wrong; it gets a unit-style check in Phase 5.
- **Fixed card height with optional badge and old-price line.** Space is reserved unconditionally, not conditionally rendered, or rows go ragged the moment one product lacks a discount.
- **Compare table on mobile.** Frozen first column plus horizontal scroll is the one place a sticky/overflow interaction commonly breaks; budgeted for in Phase 7, not squeezed in.
- **Hydration.** Cart and compare counts in the header are the classic mismatch source. Badges render from post-mount state.
- **Lighthouse ≥ 90 mobile.** Self-hosted variable fonts plus SSR should carry it; if it fails it will be font loading, so `font-display: swap` and preload from the start.

---

## 8. What I do not build

Backend of any kind, real auth (mock tokens only), payment integration, and real product photography. Search is client-side over the fixtures. The footer carries the required line: `Portfolio loyihasi. Hech qanday real do'kon bilan bog'liq emas.`
