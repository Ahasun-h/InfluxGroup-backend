import { ref, onMounted, onUnmounted } from 'vue'

export function useScrollAnimation() {
  const isVisible = ref(false)
  const elementRef = ref(null)

  let observer = null

  const checkVisibility = () => {
    if (!elementRef.value) return

    const rect = elementRef.value.getBoundingClientRect()
    const windowHeight = window.innerHeight

    isVisible.value = rect.top < windowHeight * 0.85 && rect.bottom > 0
  }

  onMounted(() => {
    checkVisibility()
    window.addEventListener('scroll', checkVisibility)
    window.addEventListener('resize', checkVisibility)

    // Initial check
    setTimeout(checkVisibility, 100)
  })

  onUnmounted(() => {
    window.removeEventListener('scroll', checkVisibility)
    window.removeEventListener('resize', checkVisibility)
    if (observer) {
      observer.disconnect()
    }
  })

  return {
    isVisible,
    elementRef
  }
}

export function useScrollAnimations() {
  const elements = ref([])

  const observeElement = (element) => {
    if (!element) return

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible')
          }
        })
      },
      {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
      }
    )

    observer.observe(element)
    elements.value.push(observer)

    return observer
  }

  onUnmounted(() => {
    elements.value.forEach((observer) => observer.disconnect())
  })

  return {
    observeElement
  }
}
