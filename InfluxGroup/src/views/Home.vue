<template>
  <div class="homepage">
    <!-- Loading State -->
    <div v-if="loading" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-brand-500 mx-auto mb-4"></div>
        <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading homepage content...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <svg class="w-20 h-20 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-xl font-bold text-red-600 mb-2">Failed to load content</p>
        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ error }}</p>
        <button @click="fetchHomepageContent" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">
          Try Again
        </button>
      </div>
    </div>

    <!-- Homepage Content -->
    <div v-else-if="homepage" class="space-y-0">
      <!-- Hero Section -->
      <HeroSection
        :hero="homepage.hero"
        :company="company"
      />

      <!-- Statistics Section -->
      <StatsSection :stats="homepage.stats" />

      <!-- Services Section -->
      <ServicesSection
        :title="homepage.services_title"
        :subtitle="homepage.services_subtitle"
      />

      <!-- Projects Section -->
      <ProjectsSection
        :title="homepage.projects_title"
        :subtitle="homepage.projects_subtitle"
      />

      <!-- Testimonials Section -->
      <TestimonialsSection
        :title="homepage.testimonials_title"
        :subtitle="homepage.testimonials_subtitle"
      />

      <!-- CTA Section -->
      <CTASection :cta="homepage.cta_section" />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useHomepage } from '@/composables/useHomepage'
import HeroSection from '@/components/homepage/HeroSection.vue'
import StatsSection from '@/components/homepage/StatsSection.vue'
import ServicesSection from '@/components/homepage/ServicesSection.vue'
import ProjectsSection from '@/components/homepage/ProjectsSection.vue'
import TestimonialsSection from '@/components/homepage/TestimonialsSection.vue'
import CTASection from '@/components/homepage/CTASection.vue'

const {
  homepage,
  company,
  loading,
  error,
  fetchHomepageContent
} = useHomepage()

onMounted(() => {
  fetchHomepageContent()
})
</script>