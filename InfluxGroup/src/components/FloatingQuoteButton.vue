<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Briefcase, X, Phone, Mail, ArrowRight, ShieldCheck } from 'lucide-vue-next'

const isOpen = ref(false)
const isVisible = ref(false)

const toggleChat = () => {
  isOpen.value = !isOpen.value
}

const closeChat = () => {
  isOpen.value = false
}

// Show button after scrolling down
const handleScroll = () => {
  isVisible.value = window.scrollY > 400
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  // Check initial scroll position
  handleScroll()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
  <!-- Floating Quote Button -->
  <Transition
    enter-active-class="transition-all duration-300"
    enter-from-class="opacity-0 translate-y-8"
    enter-to-class="opacity-100 translate-y-0"
    leave-active-class="transition-all duration-200"
    leave-from-class="opacity-100 translate-y-0"
    leave-to-class="opacity-0 translate-y-8"
  >
    <div
      v-if="isVisible"
      class="fixed bottom-6 right-6 z-40"
      :class="isOpen ? 'z-50' : 'z-40'"
    >
      <!-- Main Button -->
      <button
        v-if="!isOpen"
        @click="toggleChat"
        class="flex items-center gap-3 bg-industrial-blue hover:bg-industrial-red text-white px-5 py-4 rounded-full font-black uppercase tracking-wider text-xs transition-all duration-300 shadow-2xl hover:shadow-industrial-blue/50 hover:scale-105 active:scale-95 animate-pulse-hover"
      >
        <Briefcase class="w-5 h-5" />
        <span class="hidden sm:inline">Get Quote</span>
        <span class="sm:hidden">Quote</span>
      </button>

      <!-- Expanded Panel -->
      <Transition
        enter-active-class="transition-all duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition-all duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-if="isOpen"
          class="bg-white rounded-2xl shadow-2xl p-6 mb-4 min-w-[320px]"
        >
          <!-- Header -->
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="text-lg font-display font-black uppercase italic text-industrial-dark">
                Get Your Quote
              </h3>
              <p class="text-xs text-slate-500">Quick response guaranteed</p>
            </div>
            <button
              @click="closeChat"
              class="w-8 h-8 bg-slate-100 hover:bg-slate-200 rounded-full flex items-center justify-center transition-colors"
            >
              <X class="w-4 h-4 text-slate-600" />
            </button>
          </div>

          <!-- Contact Options -->
          <div class="space-y-3">
            <a
              href="tel:+88029876543"
              class="flex items-center gap-3 p-3 bg-industrial-light hover:bg-industrial-blue hover:text-white rounded-lg transition-colors group"
            >
              <div class="w-10 h-10 bg-industrial-blue rounded-full flex items-center justify-center group-hover:bg-white">
                <Phone class="w-5 h-5 text-white group-hover:text-industrial-blue" />
              </div>
              <div class="flex-1">
                <div class="text-xs font-bold text-industrial-dark">Call Us</div>
                <div class="text-xs text-slate-500">+880 2 987 6543</div>
              </div>
            </a>

            <a
              href="mailto:info@influxgroup.com"
              class="flex items-center gap-3 p-3 bg-industrial-light hover:bg-industrial-blue hover:text-white rounded-lg transition-colors group"
            >
              <div class="w-10 h-10 bg-industrial-blue rounded-full flex items-center justify-center group-hover:bg-white">
                <Mail class="w-5 h-5 text-white group-hover:text-industrial-blue" />
              </div>
              <div class="flex-1">
                <div class="text-xs font-bold text-industrial-dark">Email Us</div>
                <div class="text-xs text-slate-500">info@influxgroup.com</div>
              </div>
            </a>

            <a
              href="/contact?type=quote"
              class="flex items-center justify-center gap-2 w-full py-3 bg-industrial-blue hover:bg-industrial-red text-white rounded-lg font-black uppercase tracking-wider text-xs transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 active:scale-95"
            >
              <Briefcase class="w-4 h-4" />
              Request Quote
              <ArrowRight class="w-4 h-4" />
            </a>
          </div>

          <!-- Trust Badge -->
          <div class="mt-4 pt-4 border-t border-slate-200">
            <div class="flex items-center gap-2 text-[10px] text-slate-600">
              <ShieldCheck class="w-4 h-4 text-green-500" />
              <span class="font-bold">Trusted by 250+ companies</span>
            </div>
          </div>
        </div>
      </Transition>
    </div>
  </Transition>
</template>

<style scoped>
.animate-pulse:hover {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: .8;
  }
}
</style>
