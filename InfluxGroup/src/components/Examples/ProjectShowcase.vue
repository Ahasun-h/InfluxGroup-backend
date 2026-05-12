<template>
  <div class="project-showcase">
    <!-- Header -->
    <div class="text-center mb-12">
      <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Projects</h2>
      <p class="text-xl text-gray-600">Explore our portfolio of successful projects</p>
    </div>

    <!-- Category Filter -->
    <div class="flex justify-center gap-4 mb-8">
      <button
        v-for="category in categories"
        :key="category"
        @click="filterByCategory(category)"
        :class="[
          'px-6 py-2 rounded-full font-semibold transition-all',
          selectedCategory === category
            ? 'bg-brand-500 text-white'
            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
        ]"
      >
        {{ category }}
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center h-64">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-500"></div>
    </div>

    <!-- Projects Grid -->
    <div v-else-if="projects" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div
        v-for="project in projects"
        :key="project.id"
        class="project-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300"
      >
        <!-- Project Image -->
        <div class="relative h-56 overflow-hidden">
          <img
            :src="project.image || '/placeholder-project.jpg'"
            :alt="project.title"
            class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
          />
          <!-- Status Badge -->
          <div class="absolute top-4 right-4">
            <span
              :class="[
                'px-3 py-1 rounded-full text-xs font-bold',
                project.status === 'active'
                  ? 'bg-green-500 text-white'
                  : project.status === 'completed'
                  ? 'bg-blue-500 text-white'
                  : 'bg-orange-500 text-white'
              ]"
            >
              {{ project.status.toUpperCase() }}
            </span>
          </div>
        </div>

        <!-- Project Content -->
        <div class="p-6">
          <!-- Location & Client -->
          <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              {{ project.location }}
            </span>
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              {{ project.client }}
            </span>
          </div>

          <!-- Title -->
          <h3 class="text-xl font-bold text-gray-900 mb-2">{{ project.title }}</h3>

          <!-- Category -->
          <span class="inline-block text-xs font-semibold text-brand-600 uppercase tracking-wider mb-4">
            {{ project.category }}
          </span>

          <!-- Completion Progress -->
          <div v-if="project.status === 'active'" class="mb-4">
            <div class="flex justify-between text-sm mb-1">
              <span class="text-gray-600">Completion</span>
              <span class="font-semibold text-gray-900">{{ project.completion }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
              <div
                class="bg-brand-500 h-2 rounded-full transition-all duration-500"
                :style="{ width: project.completion + '%' }"
              ></div>
            </div>
          </div>

          <!-- Project Value -->
          <div class="flex items-center justify-between">
            <span class="text-2xl font-bold text-brand-600">
              ${{ Number(project.value).toLocaleString() }}
            </span>
            <router-link
              :to="`/projects/${project.slug}`"
              class="px-4 py-2 bg-brand-500 text-white rounded-lg font-semibold hover:bg-brand-600 transition-colors"
            >
              View Details
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12">
      <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
      </svg>
      <p class="text-gray-500 text-lg">No projects found for this category.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useProjects } from '@/composables/useApi'

const { projects, loading, error, fetchProjects } = useProjects()

const categories = ref(['All', 'Energy', 'Infrastructure', 'Construction'])
const selectedCategory = ref('All')

const filterByCategory = async (category) => {
  selectedCategory.value = category
  const params = { limit: 6 }

  if (category !== 'All') {
    params.category = category.toLowerCase()
  }

  await fetchProjects(params)
}

onMounted(() => {
  fetchProjects({ limit: 6 })
})
</script>

<style scoped>
.project-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.project-card:hover {
  transform: translateY(-8px);
}
</style>