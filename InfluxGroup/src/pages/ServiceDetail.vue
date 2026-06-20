<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  Cog,
  Calendar,
  Building2,
  Users,
  CheckCircle,
  ArrowLeft,
  ArrowRight,
  Clock,
  Mail,
  Phone,
  Share2
} from 'lucide-vue-next'
import { serviceService } from '../services/content'
import { API_CONFIG } from '../config/api'

const route = useRoute()
const router = useRouter()

const service = ref(null)
const isLoading = ref(true)
const error = ref(null)
const activeTab = ref('overview')

const tabs = [
  { id: 'overview', name: 'Overview' },
  { id: 'features', name: 'Features' },
  { id: 'process', name: 'Process' },
  { id: 'case-studies', name: 'Case Studies' }
]

const slug = computed(() => route.params.slug)

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const fetchService = async () => {
  try {
    isLoading.value = true
    const response = await serviceService.getServiceBySlug(slug.value)
    service.value = response
  } catch (err) {
    error.value = 'Failed to load service details. Please try again later.'
    console.error('Failed to fetch service:', err)
  } finally {
    isLoading.value = false
  }
}

const goBack = () => {
  router.push('/services')
}

const shareService = async () => {
  if (navigator.share) {
    try {
      await navigator.share({
        title: service.value?.title,
        text: service.value?.description,
        url: window.location.href
      })
    } catch (err) {
      console.log('Share canceled')
    }
  }
}

onMounted(fetchService)
</script>

<template>
  <div class="min-h-screen bg-industrial-light">
    <!-- Loading State -->
    <div v-if="isLoading" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-industrial-blue mx-auto"></div>
        <p class="mt-4 text-gray-600">Loading service details...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <p class="text-red-600 mb-4">{{ error }}</p>
        <button @click="goBack" class="px-6 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition">
          Back to Services
        </button>
      </div>
    </div>

    <!-- Service Detail -->
    <div v-else-if="service" class="animate-fade-in">
      <!-- Hero Section -->
      <section class="relative h-[60vh] bg-industrial-dark text-white overflow-hidden">
        <div class="absolute inset-0">
          <img
            :src="getImageUrl(service.image)"
            :alt="service.title"
            class="w-full h-full object-cover"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark via-industrial-dark/50 to-transparent"></div>
        </div>

        <div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-6">
          <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-industrial-blue/20 backdrop-blur-sm mb-6">
              <span class="px-3 py-1 rounded-full text-sm font-semibold capitalize">
                Service
              </span>
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
              {{ service.title }}
            </h1>

            <p class="text-xl text-slate-300 max-w-3xl mx-auto">
              {{ service.description }}
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
          @click="shareService"
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
              Service <span class="text-industrial-blue">Overview</span>
            </h2>

            <div class="prose prose-lg max-w-none">
              <div v-if="service.overview" class="text-slate-700 leading-relaxed space-y-4">
                <p>{{ service.overview }}</p>
              </div>

              <div v-else class="text-slate-700 leading-relaxed space-y-4">
                <p>{{ service.description }}</p>
                <p>
                  Our comprehensive approach ensures that every project is delivered with the highest standards of quality,
                  safety, and efficiency. We work closely with our clients to understand their unique requirements and
                  deliver customized solutions that meet their specific needs.
                </p>
              </div>
            </div>

            <!-- Quick Info -->
            <div v-if="service.duration || service.availability" class="grid md:grid-cols-2 gap-6 mt-12">
              <div v-if="service.duration" class="bg-industrial-light rounded-lg p-6">
                <div class="flex items-center gap-3 mb-2">
                  <Clock :size="24" class="text-industrial-blue" />
                  <span class="text-gray-600 dark:text-gray-400 text-sm">Typical Duration</span>
                </div>
                <div class="text-gray-900 dark:text-white font-semibold">
                  {{ service.duration }}
                </div>
              </div>

              <div v-if="service.availability" class="bg-industrial-light rounded-lg p-6">
                <div class="flex items-center gap-3 mb-2">
                  <Users :size="24" class="text-industrial-blue" />
                  <span class="text-gray-600 dark:text-gray-400 text-sm">Availability</span>
                </div>
                <div class="text-gray-900 dark:text-white font-semibold">
                  {{ service.availability }}
                </div>
              </div>
            </div>
          </div>

          <!-- Features Tab -->
          <div v-if="activeTab === 'features'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Service <span class="text-industrial-blue">Features</span>
            </h2>

            <div v-if="service.features && service.features.length" class="grid md:grid-cols-2 gap-6">
              <div
                v-for="(feature, index) in service.features"
                :key="index"
                class="bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow"
              >
                <div class="flex items-start gap-4">
                  <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                    <CheckCircle class="w-6 h-6 text-white" />
                  </div>
                  <div>
                    <h4 class="font-bold text-industrial-dark mb-2">{{ feature }}</h4>
                    <p class="text-slate-600 text-sm">
                      Designed to enhance service delivery and ensure optimal outcomes.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="text-slate-500">
              <p>Features information will be provided upon request.</p>
            </div>
          </div>

          <!-- Process Tab -->
          <div v-if="activeTab === 'process'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Our <span class="text-industrial-blue">Process</span>
            </h2>

            <div v-if="service.process && service.process.length" class="space-y-6">
              <div
                v-for="(step, index) in service.process"
                :key="index"
                class="flex gap-6"
              >
                <div class="flex-shrink-0">
                  <div class="w-16 h-16 bg-industrial-blue rounded-full flex items-center justify-center text-white font-bold text-xl">
                    {{ index + 1 }}
                  </div>
                </div>
                <div class="flex-1 bg-white rounded-lg p-6 shadow-md">
                  <h3 class="text-xl font-bold text-industrial-dark mb-2">{{ step.title }}</h3>
                  <p class="text-slate-600">{{ step.description }}</p>
                </div>
              </div>
            </div>

            <div v-else class="text-slate-500">
              <p>Process information will be provided upon request.</p>
            </div>
          </div>

          <!-- Case Studies Tab -->
          <div v-if="activeTab === 'case-studies'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Related <span class="text-industrial-blue">Projects</span>
            </h2>

            <div v-if="service.projects && service.projects.length" class="grid md:grid-cols-2 gap-6">
              <div
                v-for="(project, index) in service.projects"
                :key="index"
                class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow cursor-pointer"
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

            <div v-else class="text-slate-500">
              <p>Case studies will be provided upon request.</p>
            </div>
          </div>

        </div>
      </section>

      <!-- CTA Section -->
      <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="bg-gradient-to-r from-industrial-blue to-industrial-dark rounded-xl p-8 md:p-12 text-center text-white">
          <h2 class="text-3xl font-bold mb-4">Interested in This Service?</h2>
          <p class="text-lg mb-6 opacity-90">Contact us to learn more about how we can help with your requirements.</p>
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