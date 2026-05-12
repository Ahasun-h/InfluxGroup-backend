<template>
  <section class="py-16 md:py-24 bg-gray-50 dark:bg-surface-800">
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

      <!-- Projects Grid -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="project in projects"
          :key="project.id"
          class="group bg-white dark:bg-surface-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1"
        >
          <!-- Project Image -->
          <div class="relative h-56 overflow-hidden">
            <img
              :src="project.image || '/placeholder-project.jpg'"
              :alt="project.title"
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
            />

            <!-- Status Badge -->
            <div class="absolute top-4 right-4">
              <span
                :class="[
                  'px-3 py-1 rounded-full text-xs font-bold',
                  project.status === 'active'
                    ? 'bg-green-500 text-white'
                    : 'bg-blue-500 text-white'
                ]"
              >
                {{ project.status.toUpperCase() }}
              </span>
            </div>
          </div>

          <!-- Project Details -->
          <div class="p-6">
            <!-- Location & Client -->
            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-3">
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ project.location }}
              </span>
            </div>

            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
              {{ project.title }}
            </h3>

            <!-- Category -->
            <span class="inline-block text-xs font-semibold text-brand-600 uppercase tracking-wider mb-4">
              {{ project.category }}
            </span>

            <!-- Progress for Active Projects -->
            <div v-if="project.status === 'active'" class="mb-4">
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600 dark:text-gray-400">Completion</span>
                <span class="font-semibold text-gray-900 dark:text-white">{{ project.completion }}%</span>
              </div>
              <div class="w-full bg-gray-200 dark:bg-surface-600 rounded-full h-2">
                <div
                  class="bg-brand-500 h-2 rounded-full transition-all duration-500"
                  :style="{ width: project.completion + '%' }"
                ></div>
              </div>
            </div>

            <!-- Project Value -->
            <div class="flex items-center justify-between">
              <span class="text-xl font-bold text-brand-600">
                ${{ Number(project.value).toLocaleString() }}
              </span>
              <a
                :href="`/projects/${project.slug}`"
                class="px-4 py-2 bg-brand-500 text-white rounded-lg font-semibold hover:bg-brand-600 transition-colors"
              >
                View Details
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- View All Link -->
      <div class="text-center mt-12">
        <a
          href="/projects"
          class="inline-flex items-center px-8 py-4 bg-brand-500 text-white rounded-xl font-bold hover:bg-brand-600 transition-all shadow-lg hover:shadow-xl"
        >
          View All Projects
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
import { useProjects } from '@/composables/useApi'

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

const { projects, loading, fetchFeaturedProjects } = useProjects()

onMounted(() => {
  fetchFeaturedProjects({ limit: 6 })
})
</script>