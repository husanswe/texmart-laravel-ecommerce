<script setup lang="ts">
import { Heart, Scale } from '@lucide/vue'

const props = defineProps<{ productId: number }>()

const favorites = useFavoritesStore()
const compare = useCompareStore()

const isFav = computed(() => favorites.has(props.productId))
const isCompared = computed(() => compare.has(props.productId))
const compareBlocked = computed(() => compare.isFull && !isCompared.value)
</script>


<template>
  <div class="flex items-center gap-2">
    <button
      type="button"
      class="btn-press flex size-9 items-center justify-center rounded-full bg-white/90 shadow-sm transition hover:bg-white"
      :aria-pressed="isFav"
      :aria-label="isFav ? 'Tanlanganlardan olib tashlash' : 'Tanlanganlarga qo\'shish'"
      @click.prevent.stop="favorites.toggle(productId)"
    >
      <Heart class="size-5" :class="isFav ? 'fill-red-500 text-red-500' : 'text-ink-500'" />
    </button>

    <button
      type="button"
      class="btn-press flex size-9 items-center justify-center rounded-full bg-white/90 shadow-sm transition hover:bg-white disabled:cursor-not-allowed disabled:opacity-40"
      :disabled="compareBlocked"
      :aria-pressed="isCompared"
      :title="compareBlocked ? 'Eng ko\'pi bilan 4 ta mahsulotni solishtirish mumkin' : 'Taqqoslash'"
      :aria-label="isCompared ? 'Taqqoslashdan olib tashlash' : 'Taqqoslashga qo\'shish'"
      @click.prevent.stop="compare.toggle(productId)"
    >
      <Scale class="size-5" :class="isCompared ? 'text-brand-600' : 'text-ink-500'" />
    </button>
  </div>
</template>