<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
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
  Share2,
  Zap,
  Settings,
  Award,
  TrendingUp,
  Play,
  Pause,
  Star,
  ChevronDown,
  Download,
  FileText,
  Image as ImageIcon
} from 'lucide-vue-next'
import { serviceService, solutionService } from '../services/content'
import { API_CONFIG } from '../config/api'

const route = useRoute()
const router = useRouter()

const service = ref(null)
const solution = ref(null)
const isLoading = ref(true)
const error = ref(null)

// Additional dynamic elements
const currentImageIndex = ref(0)
const isAutoPlaying = ref(true)
const expandedSection = ref(null)
const activeProcessStep = ref(null)

const slug = computed(() => route.params.slug)
const contentType = computed(() => {
  return route.path.includes('/services/') ? 'service' : 'solution'
})

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const fetchContent = async () => {
  try {
    isLoading.value = true

    if (contentType.value === 'service') {
      const response = await serviceService.getServiceBySlug(slug.value)
      service.value = response
    } else {
      const response = await solutionService.getSolutionBySlug(slug.value)
      solution.value = response
    }
  } catch (err) {
    error.value = 'Failed to load content details. Please try again later.'
    console.error('Failed to fetch content:', err)
  } finally {
    isLoading.value = false
  }
}

const goBack = () => {
  router.push('/services-and-solutions')
}

const shareContent = async () => {
  if (navigator.share) {
    try {
      await navigator.share({
        title: service.value?.title || solution.value?.title,
        text: service.value?.description || solution.value?.description,
        url: window.location.href
      })
    } catch (err) {
      console.log('Share canceled')
    }
  }
}

const content = computed(() => service.value || solution.value)

// Gallery images for hero slider
const galleryImages = computed(() => {
  if (content.value?.gallery?.length) {
    return [content.value.image, ...content.value.gallery]
  }
  return [content.value.image]
})

const toggleAutoPlay = () => {
  isAutoPlaying.value = !isAutoPlaying.value
}

const nextImage = () => {
  currentImageIndex.value = (currentImageIndex.value + 1) % galleryImages.value.length
}

const prevImage = () => {
  currentImageIndex.value = (currentImageIndex.value - 1 + galleryImages.value.length) % galleryImages.value.length
}

const toggleSection = (sectionId) => {
  if (expandedSection.value === sectionId) {
    expandedSection.value = null
  } else {
    expandedSection.value = sectionId
  }
}

const setProcessStep = (index) => {
  activeProcessStep.value = activeProcessStep.value === index ? null : index
}

// Auto-advance gallery
let autoPlayInterval
onMounted(() => {
  fetchContent()

  autoPlayInterval = setInterval(() => {
    if (isAutoPlay.value && galleryImages.value.length > 1) {
      nextImage()
    }
  }, 5000)
})

// Cleanup
onBeforeUnmount(() => {
  clearInterval(autoPlayInterval)
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <!-- Loading State -->
    <div v-if="isLoading" class="flex flex-col items-center justify-center min-h-screen gap-4">
      <div class="relative">
        <div class="w-16 h-16 border-4 border-industrial-blue/30 rounded-full"></div>
        <div class="absolute top-0 left-0 w-16 h-16 border-4 border-industrial-blue border-t-transparent rounded-full animate-spin"></div>
      </div>
      <p class="text-industrial-dark font-bold uppercase tracking-widest text-sm animate-pulse">Loading amazing content...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex items-center justify-center min-h-screen">
      <div class="text-center glass-card p-12 rounded-2xl">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <Cog class="w-10 h-10 text-red-500 animate-spin" />
        </div>
        <p class="text-red-600 mb-6 text-lg">{{ error }}</p>
        <button @click="goBack" class="px-8 py-3 bg-industrial-blue text-white rounded-xl hover:bg-industrial-dark transition font-semibold shadow-lg hover:shadow-xl">
          Back to Services & Solutions
        </button>
      </div>
    </div>

    <!-- Content Detail -->
    <div v-else-if="content" class="animate-fade-in">
      <!-- Enhanced Hero Section -->
      <section class="relative min-h-[90vh] bg-gradient-to-br from-industrial-dark via-industrial-blue/20 to-slate-900 text-white overflow-hidden">
        <!-- Dynamic Background Gallery -->
        <div class="absolute inset-0">
          <Transition
            enter-active-class="transition-opacity duration-1000"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-1000"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <img
              v-if="galleryImages[currentImageIndex]"
              :key="currentImageIndex"
              :src="getImageUrl(galleryImages[currentImageIndex])"
              :alt="content.title"
              class="w-full h-full object-cover transform scale-105"
            >
          </Transition>
          <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark/95 via-industrial-dark/70 to-industrial-blue/60"></div>
        </div>

        <!-- Floating Particles Effect -->
        <div class="absolute inset-0 opacity-20">
          <div class="absolute top-20 left-10 w-2 h-2 bg-white rounded-full animate-pulse"></div>
          <div class="absolute top-40 right-20 w-3 h-3 bg-industrial-blue rounded-full animate-bounce"></div>
          <div class="absolute bottom-40 left-1/4 w-2 h-2 bg-white rounded-full animate-ping"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 py-20">
          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Content Side -->
            <div class="space-y-8" v-motion-slide-visible-left>
              <!-- Breadcrumb & Type Badge -->
              <div class="flex items-center gap-4">
                <button @click="goBack" class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full hover:bg-white/20 transition">
                  <ArrowLeft :size="18" />
                  <span class="text-sm">Back</span>
                </button>
                <span class="px-4 py-2 bg-industrial-blue rounded-full text-xs font-bold uppercase tracking-wider">
                  {{ contentType === 'service' ? 'Service' : 'Solution' }}
                </span>
              </div>

              <!-- Title -->
              <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9]">
                {{ content.title }}
              </h1>

              <!-- Description -->
              <p class="text-xl text-slate-200 leading-relaxed max-w-2xl">
                {{ content.description }}
              </p>

              <!-- Quick Stats -->
              <div class="flex flex-wrap gap-4">
                <div v-if="content.duration" class="flex items-center gap-3 px-4 py-2 bg-white/10 backdrop-blur-md rounded-lg">
                  <Clock :size="20" class="text-industrial-blue" />
                  <div>
                    <div class="text-xs text-slate-400">Duration</div>
                    <div class="font-bold text-sm">{{ content.duration }}</div>
                  </div>
                </div>
                <div v-if="content.availability" class="flex items-center gap-3 px-4 py-2 bg-white/10 backdrop-blur-md rounded-lg">
                  <Users :size="20" class="text-industrial-blue" />
                  <div>
                    <div class="text-xs text-slate-400">Availability</div>
                    <div class="font-bold text-sm">{{ content.availability }}</div>
                  </div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex flex-wrap gap-4">
                <a href="#contact" class="flex items-center gap-3 px-8 py-4 bg-industrial-blue hover:bg-industrial-red text-white rounded-xl font-bold uppercase tracking-wider transition-all shadow-2xl hover:scale-105">
                  <Mail :size="20" />
                  Get Quote
                </a>
                <button @click="shareContent" class="flex items-center gap-3 px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 rounded-xl font-bold uppercase tracking-wider transition-all">
                  <Share2 :size="20" />
                  Share
                </button>
              </div>
            </div>

            <!-- Gallery Controls Side -->
            <div class="hidden lg:flex flex-col items-center justify-center space-y-6" v-motion-slide-visible-right>
              <div class="glass-card p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                <div class="text-center mb-4">
                  <div class="text-3xl font-bold">{{ String(currentImageIndex + 1).padStart(2, '0') }}</div>
                  <div class="text-xs text-slate-400">of {{ galleryImages.length }}</div>
                </div>
                <div class="flex gap-2">
                  <button @click="prevImage" class="p-3 bg-white/10 hover:bg-white/20 rounded-lg transition">
                    <ArrowLeft :size="20" />
                  </button>
                  <button @click="toggleAutoPlay" class="p-3 bg-white/10 hover:bg-white/20 rounded-lg transition">
                    <Pause v-if="isAutoPlaying" :size="20" />
                    <Play v-else :size="20" />
                  </button>
                  <button @click="nextImage" class="p-3 bg-white/10 hover:bg-white/20 rounded-lg transition">
                    <ArrowRight :size="20" />
                  </button>
                </div>
              </div>

              <!-- Thumbnail Gallery -->
              <div class="grid grid-cols-3 gap-2">
                <div
                  v-for="(image, index) in galleryImages.slice(0, 6)"
                  :key="index"
                  @click="currentImageIndex = index"
                  class="aspect-video rounded-lg overflow-hidden cursor-pointer border-2 transition-all"
                  :class="currentImageIndex === index ? 'border-industrial-blue scale-105' : 'border-white/20 hover:border-white/40'"
                >
                  <img :src="getImageUrl(image)" class="w-full h-full object-cover" alt="Gallery thumbnail">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
          <ChevronDown :size="32" class="text-white/50" />
        </div>
      </section>

      <!-- Main Content Flow -->
      <main class="max-w-7xl mx-auto px-6 py-20 space-y-24">

        <!-- Overview Section -->
        <section class="scroll-section" v-motion-slide-visible-bottom>
          <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-industrial-blue to-industrial-blue/60 rounded-2xl flex items-center justify-center">
              <FileText :size="32" class="text-white" />
            </div>
            <div>
              <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] text-industrial-dark">
                About This {{ contentType === 'service' ? 'Service' : 'Solution' }}
              </h2>
              <p class="text-slate-500">Comprehensive overview and key details</p>
            </div>
          </div>

          <div class="glass-card p-8 md:p-12 rounded-2xl bg-gradient-to-br from-white to-slate-50">
            <div class="prose prose-lg max-w-none">
              <div v-if="content.overview" class="text-slate-700 leading-relaxed text-lg space-y-6">
                <p>{{ content.overview }}</p>
              </div>
              <div v-else class="text-slate-700 leading-relaxed text-lg space-y-6">
                <p>{{ content.description }}</p>
              </div>
            </div>

            <!-- Key Highlights Grid -->
            <div v-if="content.stats && content.stats.length" class="grid md:grid-cols-3 gap-6 mt-12">
              <div
                v-for="(stat, index) in content.stats"
                :key="index"
                class="text-center p-6 bg-industrial-blue/5 rounded-xl border border-industrial-blue/10"
              >
                <div class="text-4xl font-display font-black text-industrial-blue mb-2">{{ stat.value || stat.number }}</div>
                <div class="text-slate-600 font-medium">{{ stat.label || stat.title }}</div>
              </div>
            </div>
          </div>
        </section>

        <!-- Features Section -->
        <section v-if="content.features && content.features.length" class="scroll-section">
          <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-industrial-red to-industrial-red/60 rounded-2xl flex items-center justify-center">
              <Star :size="32" class="text-white" />
            </div>
            <div>
              <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] text-industrial-dark">
                Key Features & Benefits
              </h2>
              <p class="text-slate-500">What makes this {{ contentType }} stand out</p>
            </div>
          </div>

          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
              v-for="(feature, index) in content.features"
              :key="index"
              class="group glass-card p-8 rounded-2xl hover:shadow-2xl transition-all duration-500 border border-slate-200 hover:border-industrial-blue cursor-pointer"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <div class="w-16 h-16 bg-gradient-to-br from-industrial-blue to-industrial-blue/60 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <CheckCircle class="w-8 h-8 text-white" />
              </div>
              <h3 class="text-xl font-display font-bold text-industrial-dark mb-4 group-hover:text-industrial-blue transition-colors">
                {{ feature }}
              </h3>
              <p class="text-slate-600 leading-relaxed">
                Designed to enhance {{ contentType }} delivery and ensure optimal outcomes for your projects.
              </p>
            </div>
          </div>
        </section>

        <!-- Process Section -->
        <section v-if="content.process && content.process.length" class="scroll-section">
          <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center">
              <Settings :size="32" class="text-white" />
            </div>
            <div>
              <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] text-industrial-dark">
                Our Process
              </h2>
              <p class="text-slate-500">How we deliver excellence</p>
            </div>
          </div>

          <!-- Timeline Process -->
          <div class="relative">
            <!-- Connection Line -->
            <div class="absolute left-8 top-0 bottom-0 w-1 bg-gradient-to-b from-industrial-blue via-industrial-blue/50 to-transparent hidden md:block"></div>

            <div class="space-y-8">
              <div
                v-for="(step, index) in content.process"
                :key="index"
                class="relative flex gap-8 cursor-pointer"
                @click="setProcessStep(index)"
                v-motion-slide-visible-bottom
                :delay="index * 100"
              >
                <!-- Step Number -->
                <div class="flex-shrink-0 relative z-10">
                  <div class="w-16 h-16 bg-industrial-dark rounded-2xl flex items-center justify-center text-white font-display font-black text-2xl shadow-xl border-4 border-industrial-blue">
                    {{ String(index + 1).padStart(2, '0') }}
                  </div>
                </div>

                <!-- Step Content -->
                <div class="flex-1">
                  <div
                    class="glass-card p-8 rounded-2xl transition-all duration-500 hover:shadow-xl"
                    :class="activeProcessStep === index ? 'bg-gradient-to-br from-industrial-blue/10 to-industrial-blue/5 border-industrial-blue' : 'hover:border-industrial-blue/30'"
                  >
                    <div class="flex items-start justify-between mb-4">
                      <h3 class="text-2xl font-display font-bold text-industrial-dark">
                        {{ step.title }}
                      </h3>
                      <ChevronDown
                        class="text-industrial-blue transition-transform"
                        :class="activeProcessStep === index ? 'rotate-180' : ''"
                      />
                    </div>
                    <p class="text-slate-700 leading-relaxed">{{ step.description }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Components/Specifications Section -->
        <section v-if="content.components && content.components.length" class="scroll-section">
          <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center">
              <Zap :size="32" class="text-white" />
            </div>
            <div>
              <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] text-industrial-dark">
                Technical Components
              </h2>
              <p class="text-slate-500">Core elements and specifications</p>
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div
              v-for="(component, index) in content.components"
              :key="index"
              class="glass-card p-6 rounded-xl border-l-4 border-industrial-blue hover:shadow-lg transition-all"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-industrial-blue/10 rounded-lg flex items-center justify-center">
                  <div class="w-2 h-2 bg-industrial-blue rounded-full"></div>
                </div>
                <span class="font-bold text-industrial-dark">{{ component }}</span>
              </div>
            </div>
          </div>
        </section>

        <!-- Industries/Applications Section -->
        <section v-if="content.industries && content.industries.length" class="scroll-section">
          <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center">
              <Building2 :size="32" class="text-white" />
            </div>
            <div>
              <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] text-industrial-dark">
                Industries We Serve
              </h2>
              <p class="text-slate-500">Trusted across diverse sectors</p>
            </div>
          </div>

          <div class="flex flex-wrap gap-4">
            <div
              v-for="(industry, index) in content.industries"
              :key="index"
              class="glass-card px-6 py-4 rounded-full border border-slate-200 hover:border-industrial-blue hover:shadow-lg transition-all"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <span class="font-semibold text-industrial-dark">{{ industry }}</span>
            </div>
          </div>
        </section>

        <!-- Applications Section -->
        <section v-if="content.applications && content.applications.length" class="scroll-section">
          <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center">
              <TrendingUp :size="32" class="text-white" />
            </div>
            <div>
              <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] text-industrial-dark">
                Applications
              </h2>
              <p class="text-slate-500">Real-world use cases</p>
            </div>
          </div>

          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
              v-for="(application, index) in content.applications"
              :key="index"
              class="glass-card p-6 rounded-xl text-center hover:shadow-xl transition-all border border-slate-200 hover:border-industrial-blue"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <div class="w-12 h-12 bg-gradient-to-br from-teal-500/20 to-teal-600/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                <Award class="w-6 h-6 text-teal-600" />
              </div>
              <span class="font-semibold text-industrial-dark">{{ application }}</span>
            </div>
          </div>
        </section>

        <!-- Projects/Case Studies Section -->
        <section v-if="content.projects && content.projects.length" class="scroll-section">
          <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center">
              <ImageIcon :size="32" class="text-white" />
            </div>
            <div>
              <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] text-industrial-dark">
                Related Projects
              </h2>
              <p class="text-slate-500">See our work in action</p>
            </div>
          </div>

          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
              v-for="(project, index) in content.projects"
              :key="index"
              class="group glass-card overflow-hidden rounded-2xl hover:shadow-2xl transition-all duration-500 cursor-pointer border border-slate-200 hover:border-industrial-blue"
              v-motion-slide-visible-bottom
              :delay="index * 100"
              @click="router.push(`/projects/${project.slug}`)"
            >
              <div class="relative h-56 overflow-hidden">
                <img
                  :src="getImageUrl(project.image)"
                  :alt="project.title"
                  class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/80 to-transparent"></div>
                <div class="absolute bottom-4 left-4 right-4">
                  <h3 class="text-xl font-display font-bold text-white">{{ project.title }}</h3>
                </div>
              </div>
              <div class="p-6">
                <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">{{ project.description }}</p>
                <div class="flex items-center justify-center mt-4 text-industrial-blue font-semibold text-sm group-hover:gap-2 transition-all">
                  <span>View Project</span>
                  <ArrowRight class="w-4 h-4 opacity-0 group-hover:opacity-100" />
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Download Section -->
        <section v-if="content.benefits && content.benefits.length" class="scroll-section">
          <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center">
              <Download :size="32" class="text-white" />
            </div>
            <div>
              <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] text-industrial-dark">
                Benefits & Advantages
              </h2>
              <p class="text-slate-500">Why choose this {{ contentType }}</p>
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div
              v-for="(benefit, index) in content.benefits"
              :key="index"
              class="glass-card p-6 rounded-xl border-l-4 border-green-500 hover:shadow-lg transition-all bg-gradient-to-r from-green-50 to-white"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                  <CheckCircle class="w-6 h-6 text-white" />
                </div>
                <div>
                  <h4 class="font-bold text-industrial-dark mb-2">{{ benefit }}</h4>
                  <p class="text-slate-600 text-sm">Key advantage that sets us apart</p>
                </div>
              </div>
            </div>
          </div>
        </section>

      </main>

      <!-- Contact CTA Section -->
      <section id="contact" class="relative py-24 bg-gradient-to-br from-industrial-blue via-industrial-dark to-industrial-blue overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
          <div class="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
          <div class="absolute bottom-0 right-0 w-96 h-96 bg-industrial-blue/30 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
          <div v-motion-slide-visible-bottom>
            <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8 text-white">
              Ready to Get Started?
            </h2>
            <p class="text-xl text-slate-300 mb-12 max-w-2xl mx-auto">
              Interested in this {{ contentType }}? Contact us today and let's discuss how we can help transform your requirements into reality.
            </p>

            <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto">
              <a
                href="mailto:info@influxgroup.com?subject=Inquiry about {{ content.title }}"
                class="flex items-center justify-center gap-4 px-8 py-6 bg-white text-industrial-blue rounded-2xl font-bold uppercase tracking-wider hover:bg-gray-100 transition-all shadow-2xl hover:scale-105"
              >
                <Mail class="w-6 h-6" />
                Email Us
              </a>
              <a
                href="tel:+88029876543"
                class="flex items-center justify-center gap-4 px-8 py-6 bg-white/10 hover:bg-white/20 backdrop-blur-md border-2 border-white/30 rounded-2xl font-bold uppercase tracking-wider transition-all"
              >
                <Phone class="w-6 h-6" />
                Call Now
              </a>
            </div>

            <div class="mt-12 flex flex-wrap justify-center gap-8 text-slate-300">
              <div class="flex items-center gap-2">
                <Clock class="w-5 h-5" />
                <span>24/7 Support</span>
              </div>
              <div class="flex items-center gap-2">
                <Award class="w-5 h-5" />
                <span>Expert Team</span>
              </div>
              <div class="flex items-center gap-2">
                <TrendingUp class="w-5 h-5" />
                <span>Quality Assured</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Floating Action Button -->
      <div class="fixed bottom-8 right-8 z-50">
        <a
          href="#contact"
          class="flex items-center justify-center w-16 h-16 bg-industrial-blue hover:bg-industrial-red text-white rounded-full shadow-2xl transition-all hover:scale-110"
        >
          <Mail class="w-6 h-6" />
        </a>
      </div>
    </div>
  </div>
</template>

<style scoped>
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

.animate-fade-in {
  animation: fadeIn 0.6s ease-out;
}

.glass-card {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  border-radius: 1rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.glass-card:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Smooth scroll behavior */
html {
  scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
