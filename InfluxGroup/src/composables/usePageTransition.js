import { ref, onMounted, onUnmounted } from 'vue'

export function usePageTransition() {
  const isTransitioning = ref(false)
  const transitionName = ref('fade')

  const pageTransitions = {
    fade: {
      enterActiveClass: 'transition-all duration-500',
      enterFromClass: 'opacity-0',
      enterToClass: 'opacity-100',
      leaveActiveClass: 'transition-all duration-300',
      leaveFromClass: 'opacity-100',
      leaveToClass: 'opacity-0'
    },
    slide: {
      enterActiveClass: 'transition-all duration-500',
      enterFromClass: 'opacity-0 translate-y-8',
      enterToClass: 'opacity-100 translate-y-0',
      leaveActiveClass: 'transition-all duration-300',
      leaveFromClass: 'opacity-100 translate-y-0',
      leaveToClass: 'opacity-0 -translate-y-8'
    },
    scale: {
      enterActiveClass: 'transition-all duration-500',
      enterFromClass: 'opacity-0 scale-95',
      enterToClass: 'opacity-100 scale-100',
      leaveActiveClass: 'transition-all duration-300',
      leaveFromClass: 'opacity-100 scale-100',
      leaveToClass: 'opacity-0 scale-95'
    },
    slideLeft: {
      enterActiveClass: 'transition-all duration-500',
      enterFromClass: 'opacity-0 -translate-x-8',
      enterToClass: 'opacity-100 translate-x-0',
      leaveActiveClass: 'transition-all duration-300',
      leaveFromClass: 'opacity-100 translate-x-0',
      leaveToClass: 'opacity-0 translate-x-8'
    }
  }

  const setTransition = (name) => {
    transitionName.value = name
  }

  const startTransition = () => {
    isTransitioning.value = true
  }

  const endTransition = () => {
    isTransitioning.value = false
  }

  return {
    isTransitioning,
    transitionName,
    setTransition,
    startTransition,
    endTransition,
    pageTransitions
  }
}
