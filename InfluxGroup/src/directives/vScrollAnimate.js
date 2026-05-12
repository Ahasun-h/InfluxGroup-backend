import { useScrollAnimation } from '../composables/useScrollAnimation'

export default {
  mounted(el, binding) {
    const { isVisible } = useScrollAnimation()

    const animationClass = binding.value || 'scroll-animate'
    el.classList.add(animationClass)

    const checkVisibility = () => {
      const rect = el.getBoundingClientRect()
      const windowHeight = window.innerHeight

      if (rect.top < windowHeight * 0.85 && rect.bottom > 0) {
        el.classList.add('is-visible')
      }
    }

    // Store check function on element for cleanup
    el._scrollCheck = checkVisibility

    window.addEventListener('scroll', checkVisibility)
    window.addEventListener('resize', checkVisibility)

    // Initial check
    setTimeout(checkVisibility, 100)
  },

  unmounted(el) {
    if (el._scrollCheck) {
      window.removeEventListener('scroll', el._scrollCheck)
      window.removeEventListener('resize', el._scrollCheck)
    }
  }
}
