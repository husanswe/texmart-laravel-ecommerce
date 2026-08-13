<script setup lang="ts">
import type { Component } from 'vue'
import {
  AirVent,
  Blend,
  Box,
  Cable,
  CookingPot,
  CupSoda,
  Fan,
  Flame,
  Headphones,
  Laptop,
  Microwave,
  Monitor,
  Package,
  Phone,
  Printer,
  Projector,
  Refrigerator,
  Shirt,
  Smartphone,
  Snowflake,
  Speaker,
  Store,
  Tablet,
  Tv,
  Utensils,
  Watch,
  WashingMachine,
  Wind,
} from '@lucide/vue'

/**
 * Categories carry an icon *name* in the data, because the API will send a
 * string too. This is the one place that maps a name to a component — an
 * unknown name falls back rather than rendering nothing.
 */
const ICONS: Record<string, Component> = {
  AirVent,
  Blend,
  Box,
  Cable,
  CookingPot,
  CupSoda,
  Fan,
  Flame,
  Headphones,
  Laptop,
  Microwave,
  Monitor,
  Phone,
  Printer,
  Projector,
  Refrigerator,
  Shirt,
  Smartphone,
  Snowflake,
  Speaker,
  Store,
  Tablet,
  Tv,
  Utensils,
  Watch,
  WashingMachine,
  Wind,
}

const props = defineProps<{ name: string }>()

const icon = computed(() => ICONS[props.name] ?? Package)
</script>

<template>
  <component :is="icon" aria-hidden="true" />
</template>
