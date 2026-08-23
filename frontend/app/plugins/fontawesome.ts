import { config, library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faTelegram } from '@fortawesome/free-brands-svg-icons'

/**
 * Font Awesome, registered globally as <FontAwesomeIcon>.
 *
 * Only the icons actually used are added to the library, so the brand pack is
 * not bundled whole. Look-ups then work by prefix and name — ['fab','telegram'].
 *
 * autoAddCss is off and the stylesheet is loaded through nuxt.config instead:
 * letting the core inject its CSS at runtime makes icons flash at their
 * unstyled size on first paint under SSR.
 */
config.autoAddCss = false

library.add(faTelegram)

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.component('FontAwesomeIcon', FontAwesomeIcon)
})
