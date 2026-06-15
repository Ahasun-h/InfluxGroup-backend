<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  MapPin,
  Calendar,
  Building2,
  Zap,
  Users,
  CheckCircle2,
  ArrowLeft,
  ArrowRight,
  TrendingUp,
  Clock,
  DollarSign
} from 'lucide-vue-next'
import { projectService } from '../services/content'
import { API_CONFIG } from '../config/api'

const route = useRoute()
const router = useRouter()

const project = ref(null)
const isLoading = ref(true)
const error = ref(null)

const slug = computed(() => route.params.slug)

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1466611653911-95282fc3656b?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const fetchProject = async () => {
  try {
    isLoading.value = true
    const response = await projectService.getProjectBySlug(slug.value)
    project.value = response
  } catch (err) {
    error.value = 'Failed to load project. Please try again later.'
    console.error('Failed to fetch project:', err)
  } finally {
    isLoading.value = false
  }
}

const goBack = () => {
  router.push('/projects')
}

const getStatusColor = (status) => {
  switch (status?.toLowerCase()) {
    case 'completed': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
    case 'ongoing': return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
    case 'planned': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
    default: return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
  }
}

const formatDate = (date) => {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatCurrency = (value) => {
  if (!value) return 'N/A'
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(value)
}

onMounted(fetchProject)
</script>

<template>
  <div class="min-h-screen bg-industrial-light">
    <!-- Loading State -->
    <div v-if="isLoading" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-industrial-blue mx-auto"></div>
        <p class="mt-4 text-gray-600">Loading project details...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <p class="text-red-600 mb-4">{{ error }}</p>
        <button @click="goBack" class="px-6 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition">
          Back to Projects
        </button>
      </div>
    </div>

    <!-- Project Detail -->
    <div v-else-if="project" class="animate-fade-in">
      <!-- Hero Section -->
      <section class="relative h-[60vh] bg-industrial-dark text-white overflow-hidden">
        <div class="absolute inset-0">
          <img
            :src="getImageUrl(project.image)"
            :alt="project.title"
            class="w-full h-full object-cover"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark via-industrial-dark/50 to-transparent"></div>
        </div>

        <div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-6">
          <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-industrial-blue/20 backdrop-blur-sm mb-6">
              <span :class="getStatusColor(project.status)" class="px-3 py-1 rounded-full text-sm font-semibold capitalize">
                {{ project.status }}
              </span>
              <span v-if="project.completion" class="text-sm">
                {{ project.completion }} Complete
              </span>
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
              {{ project.title }}
            </h1>

            <div class="flex flex-wrap items-center justify-center gap-6 text-lg mt-6">
              <div v-if="project.location" class="flex items-center gap-2">
                <MapPin :size="20" />
                <span>{{ project.location }}</span>
              </div>
              <div v-if="project.capacity" class="flex items-center gap-2">
                <Zap :size="20" />
                <span>{{ project.capacity }}</span>
              </div>
              <div v-if="project.client" class="flex items-center gap-2">
                <Building2 :size="20" />
                <span>{{ project.client }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Back Button -->
        <button
          @click="goBack"
          class="absolute top-6 left-6 z-20 flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-lg hover:bg-white/20 transition"
        >
          <ArrowLeft :size="20" />
          <span>Back</span>
        </button>
      </section>

      <!-- Project Info Grid -->
      <section class="max-w-7xl mx-auto px-6 py-12 -mt-20 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Status Card -->
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-2">
              <Clock :size="24" class="text-industrial-blue" />
              <span class="text-gray-600 dark:text-gray-400 text-sm">Timeline</span>
            </div>
            <div v-if="project.start_date" class="text-gray-900 dark:text-white font-semibold">
              {{ formatDate(project.start_date) }}
            </div>
            <div v-if="project.expected_completion" class="text-sm text-gray-600 dark:text-gray-400">
              to {{ formatDate(project.expected_completion) }}
            </div>
          </div>

          <!-- Value Card -->
          <div v-if="project.value" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-2">
              <DollarSign :size="24" class="text-industrial-blue" />
              <span class="text-gray-600 dark:text-gray-400 text-sm">Project Value</span>
            </div>
            <div class="text-gray-900 dark:text-white font-semibold">
              {{ formatCurrency(project.value) }}
            </div>
          </div>

          <!-- Category Card -->
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-2">
              <TrendingUp :size="24" class="text-industrial-blue" />
              <span class="text-gray-600 dark:text-gray-400 text-sm">Category</span>
            </div>
            <div class="text-gray-900 dark:text-white font-semibold capitalize">
              {{ project.category }}
            </div>
          </div>

          <!-- Type Card -->
          <div v-if="project.type" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-2">
              <Building2 :size="24" class="text-industrial-blue" />
              <span class="text-gray-600 dark:text-gray-400 text-sm">Type</span>
            </div>
            <div class="text-gray-900 dark:text-white font-semibold capitalize">
              {{ project.type }}
            </div>
          </div>
        </div>
      </section>

      <!-- Project Stats -->
      <section v-if="project.stats && project.stats.length" class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div
            v-for="(stat, index) in project.stats"
            :key="index"
            class="bg-gradient-to-br from-industrial-blue to-industrial-dark text-white rounded-xl p-6 text-center"
          >
            <div class="text-3xl font-bold mb-1">{{ stat.value }}</div>
            <div class="text-sm opacity-90">{{ stat.label }}</div>
          </div>
        </div>
      </section>

      <!-- Project Scope -->
      <section v-if="project.scope && project.scope.length" class="max-w-7xl mx-auto px-6 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Project Scope</h2>
          <ul class="space-y-3">
            <li
              v-for="(item, index) in project.scope"
              :key="index"
              class="flex items-start gap-3"
            >
              <CheckCircle2 :size="20" class="text-green-500 mt-1 flex-shrink-0" />
              <span class="text-gray-700 dark:text-gray-300">{{ item }}</span>
            </li>
          </ul>
        </div>
      </section>

      <!-- Project Highlights -->
      <section v-if="project.highlights && project.highlights.length" class="max-w-7xl mx-auto px-6 py-8">
        <div class="bg-gradient-to-br from-industrial-blue to-industrial-dark text-white rounded-xl shadow-lg p-8">
          <h2 class="text-2xl font-bold mb-6">Project Highlights</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
              v-for="(highlight, index) in project.highlights"
              :key="index"
              class="flex items-start gap-3 bg-white/10 rounded-lg p-4"
            >
              <CheckCircle2 :size="20" class="text-green-400 mt-1 flex-shrink-0" />
              <span class="text-white/90">{{ highlight }}</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Project Gallery -->
      <section v-if="project.images && project.images.length" class="max-w-7xl mx-auto px-6 py-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Project Gallery</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div
            v-for="(image, index) in project.images"
            :key="index"
            class="aspect-video rounded-xl overflow-hidden"
          >
            <img
              :src="getImageUrl(image)"
              :alt="`${project.title} - Image ${index + 1}`"
              class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
            >
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="bg-gradient-to-r from-industrial-blue to-industrial-dark rounded-xl p-8 md:p-12 text-center text-white">
          <h2 class="text-3xl font-bold mb-4">Interested in This Project?</h2>
          <p class="text-lg mb-6 opacity-90">Contact us to learn more about our capabilities and how we can help with your next project.</p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button
              @click="router.push('/contact')"
              class="px-8 py-3 bg-white text-industrial-blue font-semibold rounded-lg hover:bg-gray-100 transition"
            >
              Contact Us
            </button>
            <button
              @click="router.push('/projects')"
              class="px-8 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition"
            >
              View More Projects
            </button>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
