<script setup>
import { ref, computed } from 'vue'
import { X, ChevronLeft, ChevronRight } from 'lucide-vue-next'

const props = defineProps({
  images: {
    type: Array,
    required: true,
    validator: (value) => value.every(img => img.src && img.title)
  },
  autoplay: {
    type: Boolean,
    default: false
  },
  interval: {
    type: Number,
    default: 5000
  }
})

const currentIndex = ref(0)
const isPlaying = ref(props.autoplay)

const currentImage = computed(() => props.images[currentIndex.value])
const hasPrevious = computed(() => currentIndex.value > 0)
const hasNext = computed(() => currentIndex.value < props.images.length - 1)

const next = () => {
  if (hasNext.value) {
    currentIndex.value++
  } else {
    currentIndex.value = 0
  }
}

const previous = () => {
  if (hasPrevious.value) {
    currentIndex.value--
  } else {
    currentIndex.value = props.images.length - 1
  }
}

const goTo = (index) => {
  currentIndex.value = index
}

// Autoplay functionality
let intervalId = null

const startAutoplay = () => {
  if (!intervalId) {
    intervalId = setInterval(next, props.interval)
    isPlaying.value = true
  }
}

const stopAutoplay = () => {
  if (intervalId) {
    clearInterval(intervalId)
    intervalId = null
    isPlaying.value = false
  }
}

watch(() => props.autoplay, (newValue) => {
  if (newValue) {
    startAutoplay()
  } else {
    stopAutoplay()
  }
}, { immediate: true })

onUnmounted(() => {
  stopAutoplay()
})
</script>

<template>
  <div class="relative">
    <!-- Main Image -->
    <div class="relative aspect-video overflow-hidden rounded-lg bg-slate-900">
      <Transition
        mode="out-in"
        enter-active-class="transition-all duration-500"
        enter-from-class="opacity-0 scale-105"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition-all duration-500"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <img
          :key="currentIndex"
          :src="currentImage.src"
          :alt="currentImage.title"
          class="w-full h-full object-cover"
        />
      </Transition>

      <!-- Overlay Info -->
      <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 to-transparent">
        <h3 class="text-xl font-display font-black text-white mb-1">{{ currentImage.title }}</h3>
        <p v-if="currentImage.description" class="text-slate-300 text-sm">{{ currentImage.description }}</p>
      </div>

      <!-- Navigation Buttons -->
      <button
        v-if="hasPrevious"
        @click="previous"
        class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/50 hover:bg-black/70 text-white rounded-full flex items-center justify-center transition-colors"
      >
        <ChevronLeft class="w-6 h-6" />
      </button>
      <button
        v-if="hasNext"
        @click="next"
        class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/50 hover:bg-black/70 text-white rounded-full flex items-center justify-center transition-colors"
      >
        <ChevronRight class="w-6 h-6" />
      </button>
    </div>

    <!-- Thumbnails -->
    <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
      <button
        v-for="(image, index) in images"
        :key="index"
        @click="goTo(index)"
        :class="[
          'flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition-all',
          currentIndex === index ? 'border-industrial-blue scale-110' : 'border-transparent opacity-60 hover:opacity-100'
        ]"
      >
        <img
          :src="image.src"
          :alt="image.title"
          class="w-full h-full object-cover"
        />
      </button>
    </div>

    <!-- Counter -->
    <div class="flex items-center justify-between mt-4">
      <div class="text-sm text-slate-600">
        {{ currentIndex + 1 }} / {{ images.length }}
      </div>
      <button
        v-if="autoplay"
        @click="isPlaying ? stopAutoplay() : startAutoplay()"
        class="text-xs font-bold uppercase tracking-wider text-industrial-blue hover:text-industrial-red transition-colors"
      >
        {{ isPlaying ? 'Pause' : 'Play' }}
      </button>
    </div>
  </div>
</template>
