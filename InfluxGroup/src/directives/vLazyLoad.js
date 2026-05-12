export default {
  mounted(el, binding) {
    const imageUrl = binding.value
    const placeholder = binding.arg || 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300"%3E%3C/svg%3E'

    el.src = placeholder
    el.dataset.src = imageUrl

    const loadImage = () => {
      const img = new Image()

      img.onload = () => {
        el.src = imageUrl
        el.classList.add('lazy-loaded')
      }

      img.onerror = () => {
        el.classList.add('lazy-error')
      }

      img.src = imageUrl
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            loadImage()
            observer.unobserve(el)
          }
        })
      },
      {
        rootMargin: '100px'
      }
    )

    observer.observe(el)

    // Store observer for cleanup
    el._lazyObserver = observer
  },

  unmounted(el) {
    if (el._lazyObserver) {
      el._lazyObserver.disconnect()
    }
  }
}
