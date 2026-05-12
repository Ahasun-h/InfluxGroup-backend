import { ref, onMounted, onUnmounted } from 'vue'

export function useLazyLoad(threshold = 0.1) {
  const isLoaded = ref(false)
  const elementRef = ref(null)

  let observer = null

  onMounted(() => {
    if (!elementRef.value) return

    observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            isLoaded.value = true
            if (observer) {
              observer.disconnect()
            }
          }
        })
      },
      {
        threshold,
        rootMargin: '50px'
      }
    )

    observer.observe(elementRef.value)
  })

  onUnmounted(() => {
    if (observer) {
      observer.disconnect()
    }
  })

  return {
    isLoaded,
    elementRef
  }
}

export function useLazyImage(src, options = {}) {
  const {
    threshold = 0.1,
    placeholder = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300"%3E%3C/svg%3E'
  } = options

  const loadedSrc = ref(placeholder)
  const isLoaded = ref(false)
  const hasError = ref(false)
  const imageRef = ref(null)

  let observer = null

  const loadImage = () => {
    const img = new Image()

    img.onload = () => {
      loadedSrc.value = src
      isLoaded.value = true
    }

    img.onerror = () => {
      hasError.value = true
    }

    img.src = src
  }

  onMounted(() => {
    if (!imageRef.value) return

    observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            loadImage()
            if (observer) {
              observer.disconnect()
            }
          }
        })
      },
      {
        threshold,
        rootMargin: '100px'
      }
    )

    observer.observe(imageRef.value)
  })

  onUnmounted(() => {
    if (observer) {
      observer.disconnect()
    }
  })

  return {
    loadedSrc,
    isLoaded,
    hasError,
    imageRef
  }
}
