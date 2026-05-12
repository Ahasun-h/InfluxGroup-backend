import { ref, onMounted, onUnmounted } from 'vue'

export function useParallax(speed = 0.5) {
  const elementRef = ref(null)
  const translate = ref({ x: 0, y: 0 })

  const handleScroll = () => {
    if (!elementRef.value) return

    const rect = elementRef.value.getBoundingClientRect()
    const scrolled = window.scrollY
    const rate = scrolled * speed

    translate.value = {
      x: 0,
      y: rate
    }
  }

  onMounted(() => {
    window.addEventListener('scroll', handleScroll)
    handleScroll()
  })

  onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
  })

  return {
    elementRef,
    translate
  }
}

export function useMouseParallax(intensity = 20) {
  const elementRef = ref(null)
  const translate = ref({ x: 0, y: 0 })

  const handleMouseMove = (event) => {
    if (!elementRef.value) return

    const rect = elementRef.value.getBoundingClientRect()
    const centerX = rect.left + rect.width / 2
    const centerY = rect.top + rect.height / 2

    const mouseX = event.clientX - centerX
    const mouseY = event.clientY - centerY

    translate.value = {
      x: (mouseX / window.innerWidth) * intensity,
      y: (mouseY / window.innerHeight) * intensity
    }
  }

  const handleMouseLeave = () => {
    translate.value = { x: 0, y: 0 }
  }

  onMounted(() => {
    const element = elementRef.value
    if (element) {
      element.addEventListener('mousemove', handleMouseMove)
      element.addEventListener('mouseleave', handleMouseLeave)
    }
  })

  onUnmounted(() => {
    const element = elementRef.value
    if (element) {
      element.removeEventListener('mousemove', handleMouseMove)
      element.removeEventListener('mouseleave', handleMouseLeave)
    }
  })

  return {
    elementRef,
    translate
  }
}
