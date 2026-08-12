# Texmart

An electronics and home-appliance store for the Uzbek market — a Nuxt 4 storefront
talking to a Laravel JSON API.

Portfolio project. Not affiliated with any real shop.

## Repository layout

| Path | What it is | Status |
|---|---|---|
| `frontend/` | Nuxt 4 storefront — SSR, TypeScript, Tailwind v4 | In progress |
| `backend/` | Laravel 13 JSON API + Filament admin | Not started |
| `PLAN.md` | Frontend build plan: structure, tokens, phase order | — |

The two apps are independent. The frontend runs entirely on JSON fixtures until
the API exists, then switches over with two environment variables — no UI change:

```bash
NUXT_PUBLIC_USE_MOCKS=false
NUXT_PUBLIC_API_BASE=http://localhost:8000/api/v1
```

## Running the frontend

Node 22 LTS and pnpm.

```bash
cd frontend && pnpm install && pnpm dev
```

`pnpm build` produces the production server; `pnpm preview` runs it.
