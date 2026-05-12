import { ref, onMounted } from 'vue'

export function useTypewriter(text, options = {}) {
  const {
    speed = 50,
    delay = 0,
    cursor = true,
    loop = false,
    loopDelay = 2000
  } = options

  const displayedText = ref('')
  const showCursor = ref(true)
  const isTyping = ref(false)

  let timeoutId = null

  const type = async () => {
    isTyping.value = true

    // Initial delay
    if (delay > 0) {
      await new Promise(resolve => {
        timeoutId = setTimeout(resolve, delay)
      })
    }

    // Type each character
    for (let i = 0; i < text.length; i++) {
      displayedText.value = text.slice(0, i + 1)
      await new Promise(resolve => {
        timeoutId = setTimeout(resolve, speed)
      })
    }

    isTyping.value = false

    // Loop if enabled
    if (loop) {
      await new Promise(resolve => {
        timeoutId = setTimeout(resolve, loopDelay)
      })

      // Delete and retype
      for (let i = text.length; i >= 0; i--) {
        displayedText.value = text.slice(0, i)
        await new Promise(resolve => {
          timeoutId = setTimeout(resolve, speed / 2)
        })
      }

      // Restart
      type()
    }
  }

  onMounted(() => {
    type()
  })

  return {
    displayedText,
    showCursor,
    isTyping
  }
}

export function useTypewriterPhrases(phrases, options = {}) {
  const {
    speed = 100,
    deleteSpeed = 50,
    delayBetweenPhrases = 2000,
    cursor = true
  } = options

  const currentPhrase = ref('')
  const currentPhraseIndex = ref(0)
  const isDeleting = ref(false)

  let timeoutId = null

  const type = async () => {
    const phrase = phrases[currentPhraseIndex.value]

    if (!isDeleting.value) {
      // Type character
      currentPhrase.value = phrase.slice(0, currentPhrase.value.length + 1)

      if (currentPhrase.value === phrase) {
        // Finished typing phrase
        await new Promise(resolve => {
          timeoutId = setTimeout(resolve, delayBetweenPhrases)
        })
        isDeleting.value = true
      }
    } else {
      // Delete character
      currentPhrase.value = phrase.slice(0, currentPhrase.value.length - 1)

      if (currentPhrase.value === '') {
        // Finished deleting, move to next phrase
        isDeleting.value = false
        currentPhraseIndex.value = (currentPhraseIndex.value + 1) % phrases.length
      }
    }

    const currentSpeed = isDeleting.value ? deleteSpeed : speed
    timeoutId = setTimeout(type, currentSpeed)
  }

  onMounted(() => {
    type()
  })

  return {
    currentPhrase,
    currentPhraseIndex,
    isDeleting
  }
}
