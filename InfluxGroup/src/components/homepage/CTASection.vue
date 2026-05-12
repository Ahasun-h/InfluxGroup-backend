<template>
  <section class="py-16 md:py-24 bg-gradient-to-br from-brand-600 to-brand-700 text-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl md:text-4xl font-extrabold font-outfit mb-6">
        {{ cta.title }}
      </h2>

      <p class="text-xl text-brand-100 mb-8 max-w-2xl mx-auto">
        {{ cta.description }}
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a
          :href="cta.button_link"
          class="px-8 py-4 bg-white text-brand-600 rounded-xl font-bold text-lg hover:bg-brand-50 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
        >
          {{ cta.button_text }}
        </a>

        <a
          href="/projects"
          class="px-8 py-4 bg-brand-500/20 backdrop-blur-md border-2 border-white/30 text-white rounded-xl font-bold text-lg hover:bg-brand-500/30 transition-all"
        >
          View Our Work
        </a>
      </div>

      <!-- Contact Info -->
      <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto">
        <div class="flex items-center justify-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 8V5z"></path>
            </svg>
          </div>
          <div class="text-left">
            <p class="text-sm text-brand-200">Call Us</p>
            <p class="font-bold">+880 2 1234 5678</p>
          </div>
        </div>

        <div class="flex items-center justify-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="text-left">
            <p class="text-sm text-brand-200">Email Us</p>
            <p class="font-bold">info@influxgroup.com</p>
          </div>
        </div>

        <div class="flex items-center justify-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <div class="text-left">
            <p class="text-sm text-brand-200">Visit Us</p>
            <p class="font-bold">Dhaka, Bangladesh</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  cta: {
    type: Object,
    required: true
  }
})
</script>