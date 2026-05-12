import { ref, onMounted, watch } from 'vue'

export function useCounterAnimation(targetValue, duration = 2000) {
  const currentValue = ref(0)
  const isAnimating = ref(false)

  const animate = () => {
    isAnimating.value = true
    const startValue = 0
    const startTime = performance.now()

    const update = (currentTime) => {
      const elapsed = currentTime - startTime
      const progress = Math.min(elapsed / duration, 1)

      // Easing function for smooth animation
      const easeOutQuart = 1 - Math.pow(1 - progress, 4)
      currentValue.value = Math.floor(startValue + (targetValue - startValue) * easeOutQuart)

      if (progress < 1) {
        requestAnimationFrame(update)
      } else {
        isAnimating.value = false
      }
    }

    requestAnimationFrame(update)
  }

  return {
    currentValue,
    isAnimating,
    animate
  }
}

export function useCounters() {
  const counters = ref([])

  const addCounter = (id, targetValue, element) => {
    counters.value.push({
      id,
      targetValue,
      element,
      hasAnimated: false
    })
  }

  const animateCounters = () => {
    counters.value.forEach((counter) => {
      if (counter.hasAnimated) return

      const rect = counter.element.getBoundingClientRect()
      const isVisible = rect.top < window.innerHeight && rect.bottom > 0

      if (isVisible) {
        counter.hasAnimated = true
        animateCounter(counter.element, counter.targetValue)
      }
    })
  }

  const animateCounter = (element, targetValue) => {
    const duration = 2000
    const startValue = 0
    const startTime = performance.now()

    const update = (currentTime) => {
      const elapsed = currentTime - startTime
      const progress = Math.min(elapsed / duration, 1)
      const easeOutQuart = 1 - Math.pow(1 - progress, 4)
      const currentValue = Math.floor(startValue + (targetValue - startValue) * easeOutQuart)

      element.textContent = formatNumber(currentValue)

      if (progress < 1) {
        requestAnimationFrame(update)
      }
    }

    requestAnimationFrame(update)
  }

  const formatNumber = (num) => {
    if (num >= 1000000) {
      return (num / 1000000).toFixed(1) + 'M'
    } else if (num >= 1000) {
      return (num / 1000).toFixed(1) + 'K'
    }
    return num.toString()
  }

  return {
    addCounter,
    animateCounters
  }
}
