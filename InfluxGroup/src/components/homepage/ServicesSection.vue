<template>
  <section class="py-16 md:py-24 bg-white dark:bg-surface-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white font-outfit mb-4">
          {{ title }}
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
          {{ subtitle }}
        </p>
      </div>

      <!-- Services Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="service in services"
          :key="service.id"
          class="group p-8 bg-gray-50 dark:bg-surface-800 rounded-2xl hover:bg-white dark:hover:bg-surface-700 hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-brand-200 dark:hover:border-brand-500"
        >
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white mb-6 group-hover:scale-110 transition-transform">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>

          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
            {{ service.title }}
          </h3>

          <p class="text-gray-600 dark:text-gray-400 mb-4">
            {{ service.description }}
          </p>

          <a
            href="/services"
            class="inline-flex items-center text-brand-600 font-semibold hover:text-brand-700 transition-colors"
          >
            Learn More
            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>

      <!-- View All Link -->
      <div class="text-center mt-12">
        <a
          href="/services"
          class="inline-flex items-center px-8 py-4 bg-brand-500 text-white rounded-xl font-bold hover:bg-brand-600 transition-all shadow-lg hover:shadow-xl"
        >
          View All Services
          <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useServices } from '@/composables/useApi'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  subtitle: {
    type: String,
    required: true
  }
})

const { services, fetchServices } = useServices()

onMounted(() => {
  fetchServices()
})
</script>