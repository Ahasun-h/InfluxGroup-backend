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

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-4 border-brand-500 mx-auto"></div>
      </div>

      <!-- Testimonials Grid -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="testimonial in testimonials"
          :key="testimonial.id"
          class="relative p-8 bg-gradient-to-br from-brand-50 to-blue-50 dark:from-brand-500/10 dark:to-blue-500/10 rounded-2xl hover:shadow-xl transition-all duration-300 border-2 border-brand-100 dark:border-brand-500/20"
        >
          <!-- Quote Icon -->
          <div class="absolute top-6 right-6 w-8 h-8 text-brand-300 dark:text-brand-500">
            <svg fill="currentColor" viewBox="0 0 24 24">
              <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
            </svg>
          </div>

          <!-- Testimonial Content -->
          <p class="text-gray-700 dark:text-gray-300 mb-6 relative z-10 line-clamp-4">
            "{{ testimonial.content }}"
          </p>

          <!-- Author Info -->
          <div class="flex items-center">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white font-bold text-lg">
              {{ testimonial.name.charAt(0) }}
            </div>
            <div class="ml-4">
              <p class="font-bold text-gray-900 dark:text-white">
                {{ testimonial.name }}
              </p>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ testimonial.role || 'Client' }}
              </p>
            </div>
          </div>

          <!-- Company -->
          <p v-if="testimonial.company" class="mt-3 text-sm font-semibold text-brand-600">
            {{ testimonial.company }}
          </p>
        </div>
      </div>

      <!-- View All Link -->
      <div class="text-center mt-12">
        <a
          href="/testimonials"
          class="inline-flex items-center px-8 py-4 bg-brand-500 text-white rounded-xl font-bold hover:bg-brand-600 transition-all shadow-lg hover:shadow-xl"
        >
          View All Testimonials
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
import { useTestimonials } from '@/composables/useApi'

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

const { testimonials, loading, fetchTestimonials } = useTestimonials()

onMounted(() => {
  fetchTestimonials()
})
</script>

<style scoped>
.line-clamp-4 {
  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>