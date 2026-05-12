<template>
  <section class="relative overflow-hidden bg-gradient-to-br from-brand-600 to-brand-400 text-white py-24 md:py-32">
    <!-- Background Image -->
    <div
      v-if="hero.background_image"
      class="absolute inset-0 bg-cover bg-center"
      :style="{ backgroundImage: `url(${hero.background_image})` }"
    >
      <div class="absolute inset-0 bg-gradient-to-r from-brand-900/80 to-brand-700/60"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold font-outfit tracking-tight mb-6">
          {{ hero.title }}
        </h1>

        <p class="text-xl md:text-2xl text-brand-50 mb-4 max-w-3xl mx-auto">
          {{ hero.subtitle }}
        </p>

        <p class="text-lg text-brand-100 mb-8 max-w-2xl mx-auto">
          {{ hero.description }}
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a
            :href="hero.cta_link"
            class="px-8 py-4 bg-white text-brand-600 rounded-xl font-bold text-lg hover:bg-brand-50 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
          >
            {{ hero.cta_text }}
          </a>

          <a
            href="/contact"
            class="px-8 py-4 bg-brand-500/20 backdrop-blur-md border-2 border-white/30 text-white rounded-xl font-bold text-lg hover:bg-brand-500/30 transition-all"
          >
            Contact Us
          </a>
        </div>
      </div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute bottom-0 left-0 right-0">
      <svg class="w-full h-16 text-gray-50 dark:text-surface-900 fill-current" viewBox="0 0 1440 100" preserveAspectRatio="none">
        <path d="M0,50 C360,100 1080,0 1440,50 L1440,100 L0,100 Z"></path>
      </svg>
    </div>
  </section>
</template>

<script setup>
defineProps({
  hero: {
    type: Object,
    required: true
  },
  company: {
    type: Object,
    default: () => ({})
  }
})
</script>