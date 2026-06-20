<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  Building2,
  Zap,
  Factory,
  Wrench,
  CheckCircle,
  ArrowLeft,
  ArrowRight,
  Calendar,
  Mail,
  Phone,
  Share2,
  TrendingUp
} from 'lucide-vue-next'
import { solutionService } from '../services/content'
import { API_CONFIG } from '../config/api'

const route = useRoute()
const router = useRouter()

const solution = ref(null)
const isLoading = ref(true)
const error = ref(null)
const activeTab = ref('overview')

const tabs = [
  { id: 'overview', name: 'Overview' },
  { id: 'components', name: 'Components' },
  { id: 'applications', name: 'Applications' },
  { id: 'benefits', name: 'Benefits' }
]

const slug = computed(() => route.params.slug)

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const fetchSolution = async () => {
  try {
    isLoading.value = true
    const response = await solutionService.getSolutionBySlug(slug.value)
    solution.value = response
  } catch (err) {
    error.value = 'Failed to load solution details. Please try again later.'
    console.error('Failed to fetch solution:', err)
  } finally {
    isLoading.value = false
  }
}

const goBack = () => {
  router.push('/solutions')
}

const shareSolution = async () => {
  if (navigator.share) {
    try {
      await navigator.share({
        title: solution.value?.title,
        text: solution.value?.description,
        url: window.location.href
      })
    } catch (err) {
      console.log('Share canceled')
    }
  }
}

onMounted(fetchSolution)
</script>

<template>
  <div class="min-h-screen bg-industrial-light">
    <!-- Loading State -->
    <div v-if="isLoading" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-industrial-blue mx-auto"></div>
        <p class="mt-4 text-gray-600">Loading solution details...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <p class="text-red-600 mb-4">{{ error }}</p>
        <button @click="goBack" class="px-6 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition">
          Back to Solutions
        </button>
      </div>
    </div>

    <!-- Solution Detail -->
    <div v-else-if="solution" class="animate-fade-in">
      <!-- Hero Section -->
      <section class="relative h-[60vh] bg-industrial-dark text-white overflow-hidden">
        <div class="absolute inset-0">
          <img
            :src="getImageUrl(solution.image)"
            :alt="solution.title"
            class="w-full h-full object-cover"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark via-industrial-dark/50 to-transparent"></div>
        </div>

        <div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-6">
          <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-industrial-blue/20 backdrop-blur-sm mb-6">
              <span class="px-3 py-1 rounded-full text-sm font-semibold capitalize">
                Solution
              </span>
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
              {{ solution.title }}
            </h1>

            <p class="text-xl text-slate-300 max-w-3xl mx-auto">
              {{ solution.description }}
            </p>
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

        <!-- Share Button -->
        <button
          @click="shareSolution"
          class="absolute top-6 right-6 z-20 flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-lg hover:bg-white/20 transition"
        >
          <Share2 :size="20" />
          <span>Share</span>
        </button>
      </section>

      <!-- Content Tabs -->
      <section class="bg-white border-b sticky top-20 z-30 shadow-md">
        <div class="max-w-7xl mx-auto px-6">
          <div class="flex gap-8">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              class="py-4 px-2 font-bold uppercase text-xs tracking-wider transition-colors relative"
              :class="activeTab === tab.id ? 'text-industrial-blue' : 'text-slate-500 hover:text-industrial-dark'"
            >
              {{ tab.name }}
              <div
                v-if="activeTab === tab.id"
                class="absolute bottom-0 left-0 right-0 h-1 bg-industrial-blue"
              ></div>
            </button>
          </div>
        </div>
      </section>

      <!-- Tab Content -->
      <section class="py-16">
        <div class="max-w-7xl mx-auto px-6">

          <!-- Overview Tab -->
          <div v-if="activeTab === 'overview'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Solution <span class="text-industrial-blue">Overview</span>
            </h2>

            <div class="prose prose-lg max-w-none">
              <div v-if="solution.overview" class="text-slate-700 leading-relaxed space-y-4">
                <p>{{ solution.overview }}</p>
              </div>

              <div v-else class="text-slate-700 leading-relaxed space-y-4">
                <p>{{ solution.description }}</p>
                <p>
                  Our comprehensive solutions are designed to address complex challenges in power infrastructure and
                  industrial applications. We integrate cutting-edge technology with proven methodologies to deliver
                  reliable, efficient, and sustainable solutions.
                </p>
              </div>
            </div>

            <!-- Key Stats -->
            <div v-if="solution.stats && solution.stats.length" class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
              <div
                v-for="(stat, index) in solution.stats"
                :key="index"
                class="bg-gradient-to-br from-industrial-blue to-industrial-dark text-white rounded-xl p-6 text-center"
              >
                <div class="text-3xl font-bold mb-1">{{ stat.value }}</div>
                <div class="text-sm opacity-90">{{ stat.label }}</div>
              </div>
            </div>
          </div>

          <!-- Components Tab -->
          <div v-if="activeTab === 'components'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Solution <span class="text-industrial-blue">Components</span>
            </h2>

            <div v-if="solution.components && solution.components.length" class="grid md:grid-cols-2 gap-6">
              <div
                v-for="(component, index) in solution.components"
                :key="index"
                class="bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow"
              >
                <div class="flex items-start gap-4">
                  <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                    <CheckCircle class="w-6 h-6 text-white" />
                  </div>
                  <div>
                    <h4 class="font-bold text-industrial-dark mb-2">{{ component.name }}</h4>
                    <p class="text-slate-600 text-sm">{{ component.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="text-slate-500">
              <p>Components information will be provided upon request.</p>
            </div>
          </div>

          <!-- Applications Tab -->
          <div v-if="activeTab === 'applications'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Typical <span class="text-industrial-blue">Applications</span>
            </h2>

            <div v-if="solution.applications && solution.applications.length" class="grid md:grid-cols-2 gap-6">
              <div
                v-for="(application, index) in solution.applications"
                :key="index"
                class="bg-gradient-to-br from-industrial-blue to-industrial-dark text-white rounded-lg p-6"
              >
                <div class="flex items-start gap-4">
                  <TrendingUp class="w-8 h-8 flex-shrink-0" />
                  <div>
                    <h4 class="font-bold text-lg mb-2">{{ application }}</h4>
                    <p class="text-industrial-100 text-sm">
                      Optimized for reliable performance in demanding environments.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="text-slate-500">
              <p>Applications information will be provided upon request.</p>
            </div>
          </div>

          <!-- Benefits Tab -->
          <div v-if="activeTab === 'benefits'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Key <span class="text-industrial-blue">Benefits</span>
            </h2>

            <div v-if="solution.benefits && solution.benefits.length" class="grid md:grid-cols-2 gap-6">
              <div
                v-for="(benefit, index) in solution.benefits"
                :key="index"
                class="bg-industrial-light rounded-lg p-6"
              >
                <div class="flex items-start gap-3">
                  <CheckCircle class="w-5 h-5 text-industrial-blue flex-shrink-0 mt-1" />
                  <span class="text-slate-700">{{ benefit }}</span>
                </div>
              </div>
            </div>

            <div v-else class="text-slate-500">
              <p>Benefits information will be provided upon request.</p>
            </div>
          </div>

        </div>
      </section>

      <!-- Related Projects -->
      <section v-if="solution.projects && solution.projects.length" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
          <h2 class="text-3xl font-display font-black uppercase italic mb-12">
            Related <span class="text-industrial-blue">Projects</span>
          </h2>

          <div class="grid md:grid-cols-3 gap-8">
            <div
              v-for="project in solution.projects"
              :key="project.id"
              class="bg-industrial-light rounded-lg overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
              @click="router.push(`/projects/${project.slug}`)"
            >
              <div class="aspect-video">
                <img
                  :src="getImageUrl(project.image)"
                  :alt="project.title"
                  class="w-full h-full object-cover"
                />
              </div>
              <div class="p-4">
                <h3 class="font-bold text-industrial-dark mb-2">{{ project.title }}</h3>
                <p class="text-slate-600 text-sm line-clamp-2">{{ project.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="bg-gradient-to-r from-industrial-blue to-industrial-dark rounded-xl p-8 md:p-12 text-center text-white">
          <h2 class="text-3xl font-bold mb-4">Interested in This Solution?</h2>
          <p class="text-lg mb-6 opacity-90">Contact us to learn more about how we can customize this solution for your needs.</p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a
              href="mailto:info@influxgroup.com"
              class="px-8 py-3 bg-white text-industrial-blue font-semibold rounded-lg hover:bg-gray-100 transition flex items-center justify-center gap-3"
            >
              <Mail class="w-5 h-5" />
              Email Us
            </a>
            <a
              href="tel:+88029876543"
              class="px-8 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition flex items-center justify-center gap-3"
            >
              <Phone class="w-5 h-5" />
              Call Us
            </a>
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