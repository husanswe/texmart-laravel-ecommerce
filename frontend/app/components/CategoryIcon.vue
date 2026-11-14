<script setup lang="ts">
import type { Component } from 'vue'
import {
  IconAirConditioning,
  IconBlender,
  IconBox,
  IconBuildingStore,
  IconCooker,
  IconCup,
  IconDeviceDesktop,
  IconDeviceLaptop,
  IconDeviceMobile,
  IconDeviceProjector,
  IconDeviceSpeaker,
  IconDeviceTablet,
  IconDeviceTv,
  IconDeviceWatch,
  IconFlame,
  IconFridge,
  IconHeadphones,
  IconIroning,
  IconMicrowave,
  IconPackage,
  IconPhone,
  IconPlug,
  IconPrinter,
  IconPropeller,
  IconShirt,
  IconSnowflake,
  IconToolsKitchen,
  IconToolsKitchen2,
  IconVacuumCleaner,
  IconWashMachine,
  IconWind,
} from '@tabler/icons-vue'

/**
 * Maps a category's icon *name* to a Tabler icon. This is the one place that
 * knows about icon packs; the rest of the app only ever passes a string.
 *
 * Names are normalised before lookup — lower-cased, with hyphens, underscores
 * and spaces removed — so the two naming styles that reach this component both
 * resolve to the same glyph:
 *
 *   - the Laravel API sends kebab-case: `washing-machine`, `air-conditioner`
 *   - the JSON fixtures still carry PascalCase Lucide names: `WashingMachine`
 *
 * That mismatch is what used to send every category to the generic fallback.
 * An unknown name still falls back rather than rendering nothing.
 */
const ICONS: Record<string, Component> = {
  // Top-level categories, as the backend names them
  smartphone: IconDeviceMobile,
  laptop: IconDeviceLaptop,
  tv: IconDeviceTv,
  refrigerator: IconFridge,
  fridge: IconFridge,
  washingmachine: IconWashMachine,
  airconditioner: IconAirConditioning,
  // "Uy uchun kichik texnika" (small home appliances) arrives from the API as
  // the key `home`. A house glyph says nothing about the products, so it gets
  // the kitchen-tools mark; the more descriptive keys resolve the same way in
  // case the seeder is ever renamed.
  home: IconToolsKitchen2,
  kitchen: IconToolsKitchen2,
  smallappliances: IconToolsKitchen2,

  // Sub-categories and fixture names
  phone: IconPhone,
  watch: IconDeviceWatch,
  cable: IconPlug,
  tablet: IconDeviceTablet,
  monitor: IconDeviceDesktop,
  printer: IconPrinter,
  box: IconBox,
  projector: IconDeviceProjector,
  snowflake: IconSnowflake,
  store: IconBuildingStore,
  wind: IconWind,
  utensils: IconToolsKitchen,
  fan: IconPropeller,
  flame: IconFlame,
  cupsoda: IconCup,
  kettle: IconCup,
  blend: IconBlender,
  blender: IconBlender,
  shirt: IconShirt,
  iron: IconIroning,
  ironing: IconIroning,
  vacuum: IconVacuumCleaner,
  microwave: IconMicrowave,
  headphones: IconHeadphones,
  speaker: IconDeviceSpeaker,
  cookingpot: IconCooker,
  airvent: IconAirConditioning,
  package: IconPackage,
}

const props = defineProps<{ name: string }>()

const normalise = (name: string) => name.toLowerCase().replace(/[-_\s]/g, '')

const icon = computed(() => ICONS[normalise(props.name ?? '')] ?? IconPackage)
</script>

<template>
  <component :is="icon" aria-hidden="true" />
</template>
