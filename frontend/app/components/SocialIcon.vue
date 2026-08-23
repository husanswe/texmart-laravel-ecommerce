<script setup lang="ts">
export type SocialNetwork = 'telegram' | 'linkedin' | 'x'

/**
 * Brand marks for the footer, drawn inline. Lucide dropped its brand icons in
 * v1, and these need their own colours anyway — a monochrome set would not read
 * as the real services.
 *
 * Each mark sits on a filled disc in the brand's own colour: Telegram and
 * LinkedIn blue, X black with a hairline ring so the disc still separates from
 * the dark footer behind it.
 */
defineProps<{ network: SocialNetwork }>()

const DISC: Record<SocialNetwork, string> = {
  telegram: 'bg-[#2AABEE]',
  linkedin: 'bg-[#0A66C2]',
  x: 'bg-black ring-1 ring-white/25',
}
</script>

<template>
  <span
    class="grid size-10 shrink-0 place-items-center rounded-full transition-transform"
    :class="DISC[network]"
    aria-hidden="true"
  >
    <!-- Telegram — paper plane -->
    <svg v-if="network === 'telegram'" viewBox="0 0 24 24" class="size-5 translate-x-[-1px] fill-white">
      <path
        d="M23.91 3.79 20.3 20.84c-.25 1.21-.98 1.5-2 .94l-5.5-4.07-2.66 2.57c-.3.3-.55.56-1.1.56-.72 0-.6-.27-.84-.95L6.3 13.7.85 12c-1.18-.35-1.19-1.16.26-1.75l21.26-8.2c.97-.43 1.9.24 1.54 1.74Z"
      />
    </svg>

    <!-- LinkedIn — the "in" mark -->
    <svg v-else-if="network === 'linkedin'" viewBox="0 0 24 24" class="size-[18px] fill-white">
      <path
        d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5ZM.02 8h4.96v14H.02V8Zm7.98 0h4.75v1.9h.07c.66-1.2 2.28-2.47 4.69-2.47 5.02 0 5.95 3.3 5.95 7.6V22h-4.96v-6.6c0-1.57-.03-3.6-2.2-3.6-2.2 0-2.54 1.72-2.54 3.5V22H8V8Z"
      />
    </svg>

    <!-- X -->
    <svg v-else viewBox="0 0 24 24" class="size-[17px] fill-white">
      <path
        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.451-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117l11.966 15.644Z"
      />
    </svg>
  </span>
</template>
