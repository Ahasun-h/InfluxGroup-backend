export default {
  mounted(el, binding) {
    const targetValue = parseInt(binding.value)
    const duration = binding.arg || 2000
    const startValue = 0
    const startTime = performance.now()
    let hasAnimated = false

    const animate = (currentTime) => {
      if (hasAnimated) return

      const elapsed = currentTime - startTime
      const progress = Math.min(elapsed / duration, 1)

      // Easing function for smooth animation
      const easeOutQuart = 1 - Math.pow(1 - progress, 4)
      const currentValue = Math.floor(startValue + (targetValue - startValue) * easeOutQuart)

      el.textContent = formatNumber(currentValue)

      if (progress < 1) {
        requestAnimationFrame(animate)
      } else {
        hasAnimated = true
      }
    }

    const formatNumber = (num) => {
      if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M'
      } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K'
      }
      return num.toString()
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !hasAnimated) {
            requestAnimationFrame(animate)
            observer.unobserve(el)
          }
        })
      },
      {
        threshold: 0.5
      }
    )

    observer.observe(el)

    // Store observer and data for cleanup
    el._counterObserver = observer
    el._hasAnimated = hasAnimated
  },

  unmounted(el) {
    if (el._counterObserver) {
      el._counterObserver.disconnect()
    }
  }
}
