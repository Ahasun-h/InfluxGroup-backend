<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { Cog, Wrench, Users, Zap, Building2, Factory, CheckCircle, ArrowRight } from 'lucide-vue-next'
import { serviceService, solutionService } from '../services/content'
import { API_CONFIG } from '../config/api'

const router = useRouter()
const services = ref([])
const solutions = ref([])
const isLoading = ref(true)
const pageContent = ref({
  hero: {
    title: '',
    subtitle: '',
    description: ''
  },
  process: {
    title: '',
    description: '',
    steps: []
  },
  industries: {
    title: '',
    description: '',
    industries: []
  },
  whyChooseUs: {
    title: '',
    points: [],
    image: '',
    stat_number: '',
    stat_label: ''
  },
  cta: {
    title: '',
    description: '',
    button_text: ''
  }
})

const serviceIcons = {
  'EPC Contracting': Cog,
  'Maintenance Services': Wrench,
  'Technical Training': Users,
  'Testing & Commissioning': Zap,
  default: Cog
}

const solutionIcons = {
  'EPC Solutions': Zap,
  'MEP Solutions': Building2,
  'Industrial Solutions': Factory,
  'Maintenance Solutions': Wrench,
  default: Building2
}

const getImageUrl = (path, fallback) => {
  if (!path) return fallback || 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const fetchContent = async () => {
  try {
    isLoading.value = true

    // Fetch services and solutions
    const [servicesResponse, solutionsResponse] = await Promise.all([
      serviceService.getServices(),
      solutionService.getSolutions()
    ])
    services.value = servicesResponse || []
    solutions.value = solutionsResponse || []

    // Fetch page content from API
    try {
      const contentResponse = await fetch(`${API_CONFIG.baseURL}/services-solutions-page`)
      const contentData = await contentResponse.json()

      if (contentData.success && contentData.data) {
        pageContent.value = contentData.data
      }
    } catch (contentError) {
      console.warn('Could not fetch page content, using defaults:', contentError)
      // Keep default values if API fails
    }

  } catch (error) {
    console.error('Failed to fetch content:', error)
  } finally {
    isLoading.value = false
  }
}

const viewServiceDetails = (service) => {
  if (service.slug) {
    router.push(`/services/${service.slug}`)
  }
}

const viewSolutionDetails = (solution) => {
  if (solution.slug) {
    router.push(`/solutions/${solution.slug}`)
  }
}

// Computed properties for dynamic content
const heroTitle = computed(() => pageContent.value.hero?.title || 'SERVICES & SOLUTIONS')
const heroSubtitle = computed(() => pageContent.value.hero?.subtitle || 'What We Offer')
const heroDescription = computed(() => pageContent.value.hero?.description || 'Comprehensive engineering services and tailored solutions from concept to commissioning, ensuring your power infrastructure operates at peak performance.')

const processTitle = computed(() => pageContent.value.process?.title || 'Our Process')
const processDescription = computed(() => pageContent.value.process?.description || 'A systematic approach to delivering excellence in every project')
const processSteps = computed(() => {
  if (pageContent.value.process?.steps && pageContent.value.process.steps.length > 0) {
    return pageContent.value.process.steps
  }
  // Default steps
  return [
    {
      step: '01',
      title: 'Consultation',
      description: 'Understanding your requirements and developing customized solutions'
    },
    {
      step: '02',
      title: 'Design',
      description: 'Engineering detailed designs and specifications for optimal performance'
    },
    {
      step: '03',
      title: 'Implementation',
      description: 'Executing projects with precision and adherence to timelines'
    },
    {
      step: '04',
      title: 'Support',
      description: 'Providing ongoing maintenance and technical support throughout lifecycle'
    }
  ]
})

const industriesTitle = computed(() => pageContent.value.industries?.title || 'Industries We Serve')
const industriesDescription = computed(() => pageContent.value.industries?.description || 'Delivering specialized solutions across diverse sectors')
const industries = computed(() => {
  if (pageContent.value.industries?.industries && pageContent.value.industries.industries.length > 0) {
    return pageContent.value.industries.industries.map((ind, index) => ({
      name: ind.name,
      icon: getIconForIndustry(ind.icon)
    }))
  }
  // Default industries
  return [
    { name: 'Power Generation', icon: Zap },
    { name: 'Textile', icon: Factory },
    { name: 'Pharmaceuticals', icon: Building2 },
    { name: 'Construction', icon: Building2 },
    { name: 'Food Processing', icon: Factory },
    { name: 'Telecom', icon: Zap }
  ]
})

const whyChooseUsTitle = computed(() => pageContent.value.whyChooseUs?.title || 'Why Choose Influx Group?')
const whyChooseUsPoints = computed(() => {
  if (pageContent.value.whyChooseUs?.points && pageContent.value.whyChooseUs.points.length > 0) {
    return pageContent.value.whyChooseUs.points
  }
  // Default points
  return [
    {
      title: '45+ Years of Excellence',
      description: 'Decades of experience in delivering power infrastructure solutions across Bangladesh.'
    },
    {
      title: 'Expert Engineering Team',
      description: 'Highly skilled professionals with expertise in power systems and renewable energy.'
    },
    {
      title: 'Quality Assurance',
      description: 'ISO 9001:2015 certified processes ensuring highest quality standards.'
    },
    {
      title: '24/7 Support',
      description: 'Round-the-clock technical support and maintenance services.'
    }
  ]
})

const whyChooseUsImage = computed(() => pageContent.value.whyChooseUs?.image || 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200')
const statNumber = computed(() => pageContent.value.whyChooseUs?.stat_number || '24/7')
const statLabel = computed(() => pageContent.value.whyChooseUs?.stat_label || 'Support Available')

const ctaTitle = computed(() => pageContent.value.cta?.title || 'Ready to Get Started?')
const ctaDescription = computed(() => pageContent.value.cta?.description || 'Contact our team to discuss your power infrastructure needs')
const ctaButtonText = computed(() => pageContent.value.cta?.button_text || 'Request Consultation')

// Helper function to map icon names to components
const getIconForIndustry = (iconName) => {
  const iconMap = {
    'Zap': Zap,
    'Factory': Factory,
    'Building2': Building2,
    'Users': Users,
    'Wrench': Wrench,
    'Cog': Cog
  }
  return iconMap[iconName] || Building2
}

onMounted(fetchContent)
</script>

<template>
  <div class="min-h-screen bg-industrial-light">
    <!-- Hero Section -->
    <section class="relative py-32 bg-industrial-dark text-white overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-industrial-blue/10 to-transparent"></div>
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div v-motion-slide-visible-left>
          <div class="flex items-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">{{ heroSubtitle }}</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8" v-html="heroTitle">
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            {{ heroDescription }}
          </p>
        </div>
      </div>
    </section>

    <!-- Services & Solutions Section -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase leading-[0.9] mb-8 text-industrial-dark">
            Our Services & <span class="text-industrial-blue">Solutions</span>
          </h2>
          <p class="text-slate-600 text-lg max-w-2xl mx-auto">
            Comprehensive engineering services and tailored solutions designed to meet your power infrastructure needs across diverse industries
          </p>
        </div>

        <div v-if="isLoading" class="flex flex-col items-center justify-center py-20 gap-4">
          <div class="w-12 h-12 border-4 border-industrial-blue border-t-transparent rounded-full animate-spin"></div>
          <p class="text-industrial-dark font-bold uppercase tracking-widest text-xs">Loading Content...</p>
        </div>

        <div v-else-if="services.length === 0 && solutions.length === 0" class="text-center py-20">
          <p class="text-xl text-slate-500 font-medium">No services or solutions available at the moment.</p>
        </div>

        <div v-else class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Services Cards -->
          <div
            v-for="(service, index) in services"
            :key="'service-' + (service.id || index)"
            class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden cursor-pointer border border-slate-200 hover:border-industrial-blue"
            v-motion-slide-visible-bottom
            :delay="index * 100"
            @click="viewServiceDetails(service)"
          >
            <!-- Icon Section -->
            <div class="h-3 bg-industrial-blue group-hover:bg-industrial-red text-industrial-dark"></div>
            <div class="p-8">
              <div class="flex items-center justify-between mb-6">
                <div class="w-16 h-16 bg-industrial-blue/10 rounded-xl flex items-center justify-center group-hover:bg-industrial-blue text-industrial-dark">
                  <component :is="serviceIcons[service.title] || serviceIcons.default" class="w-8 h-8 text-industrial-blue group-hover:text-white text-industrial-dark" />
                </div>
                <div class="flex items-center gap-2 text-industrial-blue opacity-0 group-hover:opacity-100 transition-opacity">
                  <span class="text-xs font-bold uppercase tracking-wider">Explore</span>
                  <ArrowRight class="w-4 h-4" />
                </div>
              </div>

              <h3 class="text-2xl font-display font-black uppercase italic mb-4 group-hover:text-industrial-blue text-industrial-dark">
                {{ service.title }}
              </h3>
              <p class="text-slate-600 mb-6 leading-relaxed line-clamp-3">
                {{ service.description }}
              </p>

              <div v-if="service.features && service.features.length" class="space-y-2">
                <div class="text-xs font-black uppercase tracking-wider text-slate-500 mb-3">Key Features</div>
                <div class="space-y-2">
                  <div
                    v-for="(feature, idx) in service.features.slice(0, 3)"
                    :key="idx"
                    class="flex items-center gap-2 text-sm text-slate-700"
                  >
                    <CheckCircle class="w-4 h-4 text-industrial-blue flex-shrink-0" />
                    <span class="line-clamp-1">{{ feature }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Solutions Cards -->
          <div
            v-for="(solution, index) in solutions"
            :key="'solution-' + (solution.id || index)"
            class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden cursor-pointer border border-slate-200 hover:border-industrial-blue"
            v-motion-slide-visible-bottom
            :delay="(services.length + index) * 100"
            @click="viewSolutionDetails(solution)"
          >
            <!-- Image Section -->
            <div class="relative h-48 overflow-hidden">
              <img
                :src="getImageUrl(solution.image, 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800')"
                :alt="solution.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/80 to-transparent"></div>
              <div class="absolute bottom-4 left-4 bg-industrial-blue text-white p-2 rounded-lg">
                <component :is="solutionIcons[solution.title] || solutionIcons.default" class="w-6 h-6" />
              </div>
            </div>

            <!-- Content Section -->
            <div class="p-8">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-display font-black uppercase italic group-hover:text-industrial-blue text-industrial-dark">
                  {{ solution.title }}
                </h3>
                <div class="flex items-center gap-2 text-industrial-blue opacity-0 group-hover:opacity-100 transition-opacity">
                  <span class="text-xs font-bold uppercase tracking-wider">Explore</span>
                  <ArrowRight class="w-4 h-4" />
                </div>
              </div>

              <p class="text-slate-600 mb-6 leading-relaxed line-clamp-3">
                {{ solution.description }}
              </p>

              <div v-if="solution.components && solution.components.length" class="space-y-2 mb-6">
                <div class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Core Components</div>
                <div class="space-y-2">
                  <div
                    v-for="(component, idx) in solution.components.slice(0, 3)"
                    :key="idx"
                    class="flex items-center gap-2 text-sm text-slate-700"
                  >
                    <div class="w-1.5 h-1.5 rounded-full bg-industrial-blue"></div>
                    <span class="line-clamp-1">{{ component }}</span>
                  </div>
                </div>
              </div>

              <div v-if="solution.applications && solution.applications.length" class="flex flex-wrap gap-2">
                <span
                  v-for="(app, idx) in solution.applications.slice(0, 2)"
                  :key="idx"
                  class="bg-industrial-light text-industrial-dark px-3 py-1 rounded-full text-xs font-medium"
                >
                  {{ app }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Process Section -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic mb-6" v-html="processTitle">
          </h2>
          <p class="text-slate-400 text-lg max-w-2xl mx-auto">
            {{ processDescription }}
          </p>
        </div>

        <div class="grid md:grid-cols-4 gap-8">
          <div
            v-for="(step, index) in processSteps"
            :key="index"
            class="text-center"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="text-6xl font-display font-black text-industrial-blue/30 mb-4">{{ step.step || index + 1 }}</div>
            <h3 class="text-xl font-bold mb-3">{{ step.title }}</h3>
            <p class="text-slate-400 text-sm leading-relaxed">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Industries Section -->
    <section class="py-32 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase leading-[0.9] mb-8 text-industrial-dark" v-html="industriesTitle">
          </h2>
          <p class="text-slate-600 text-lg max-w-2xl mx-auto">
            {{ industriesDescription }}
          </p>
        </div>

        <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6">
          <div
            v-for="(industry, index) in industries"
            :key="index"
            class="p-6 rounded-lg border-2 border-slate-200 text-center hover:border-industrial-blue hover:bg-industrial-light transition-all group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <component :is="industry.icon" class="w-12 h-12 text-industrial-blue mx-auto mb-4 group-hover:scale-110 transition-transform" />
            <div class="font-bold uppercase text-xs tracking-wider text-industrial-dark">{{ industry.name }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-32 bg-industrial-light">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16 items-center">
          <div v-motion-slide-visible-left>
            <h2 class="text-4xl md:text-5xl font-display font-black uppercase leading-[0.9] mb-8 text-industrial-dark" v-html="whyChooseUsTitle">
            </h2>
            <div class="space-y-6">
              <div v-for="(point, index) in whyChooseUsPoints" :key="index" class="flex items-start gap-4">
                <div class="w-12 h-12 bg-industrial-blue rounded-full flex items-center justify-center flex-shrink-0">
                  <CheckCircle class="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 class="font-bold text-lg mb-2">{{ point.title }}</h3>
                  <p class="text-slate-600 text-sm">{{ point.description }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="relative" v-motion-slide-visible-right>
            <img
              :src="whyChooseUsImage"
              class="rounded-lg shadow-2xl"
              alt="Service Team"
            />
            <div class="absolute -bottom-8 -left-8 bg-industrial-blue text-white p-8 rounded-lg shadow-xl">
              <div class="text-4xl font-display font-black mb-2">{{ statNumber }}</div>
              <div class="text-xs font-black uppercase tracking-widest">{{ statLabel }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-industrial-blue text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8" v-html="ctaTitle">
        </h2>
        <p class="text-xl mb-12 text-industrial-100">
          {{ ctaDescription }}
        </p>
        <button class="bg-white text-industrial-blue px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
          {{ ctaButtonText }}
        </button>
      </div>
    </section>
  </div>
</template>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
