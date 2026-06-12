<script setup>
import { ref, computed, onMounted } from 'vue'
import { Award, Users, Target, Zap, ShieldCheck, CheckCircle, ArrowUpRight, Building2, Factory, Settings, Star, Briefcase, Phone, Mail, MapPin, Activity, Cog, Wrench, Monitor, Cpu, Wind, ChevronRight, ArrowRight, Plus } from 'lucide-vue-next'
import { missionVisionService, coreValuesService, journeyService, careerCtaService } from '../services/content'
import { API_CONFIG } from '../config/api'

const certifications = ref([
  'ISO 9001:2015',
  'ISO 14001:2015',
  'ISO 45001:2018',
  'IEC 60076',
  'IEEE Standards',
  'BPDB Approved'
])

// Enhanced icon mapping function with comprehensive mapping
const getIconComponent = (iconName) => {
  const iconMap = {
    // Core icons
    'ShieldCheck': ShieldCheck,
    'Award': Award,
    'Users': Users,
    'TrendingUp': Target,
    'Target': Target,
    'Zap': Zap,
    'CheckCircle': CheckCircle,
    'ArrowUpRight': ArrowUpRight,

    // Additional commonly used icons
    'Building': Building2,
    'Factory': Factory,
    'Settings': Settings,
    'Star': Star,
    'Briefcase': Briefcase,
    'Phone': Phone,
    'Mail': Mail,
    'MapPin': MapPin,
    'Activity': Activity,
    'Cog': Cog,
    'Wrench': Wrench,
    'Monitor': Monitor,
    'Cpu': Cpu,
    'Wind': Wind,
    'ChevronRight': ChevronRight,
    'ArrowRight': ArrowRight,
    'Plus': Plus
  }
  return iconMap[iconName] || ShieldCheck
}

// Mission & Vision data from API
const missionVisionData = ref(null)

// Core Values data from API
const coreValuesData = ref(null)

// Journey data from API
const journeyData = ref(null)

// Career CTA data from API
const careerCtaData = ref(null)

const fetchMissionVisionData = async () => {
  try {
    console.log('Fetching mission & vision data from /api/cms/mission-vision...')
    const response = await missionVisionService.getMissionVisionData()
    console.log('Mission & vision response:', response)

    if (response && response.data) {
      missionVisionData.value = response.data
      console.log('Mission & vision data loaded successfully:', missionVisionData.value)
    } else if (response) {
      missionVisionData.value = response
      console.log('Mission & vision data loaded (direct):', missionVisionData.value)
    } else {
      console.warn('Mission & vision data response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch mission & vision data:', error)
    console.error('Error message:', error.message)

    // Set default mission & vision data as fallback
    missionVisionData.value = {
      mission: {
        title: 'Our Mission',
        description: 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
        points: [
          'Powering Bangladesh\'s development through innovative energy solutions',
          'Delivering excellence in power infrastructure projects',
          'Building sustainable energy solutions for the future'
        ]
      },
      vision: {
        title: 'Our Vision',
        description: 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
        points: [
          'Regional leadership in sustainable infrastructure development',
          'Global recognition for engineering excellence',
          'Innovation-driven growth in renewable energy sector'
        ]
      }
    }
  }
}

const missionVision = computed(() => {
  if (missionVisionData.value?.mission && missionVisionData.value?.vision) {
    console.log('Using mission & vision API data:', missionVisionData.value)
    return missionVisionData.value
  }

  // Default values if no data
  console.log('Using default mission & vision values')
  return {
    mission: {
      title: 'Our Mission',
      description: 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
      points: [
        'Powering Bangladesh\'s development through innovative energy solutions',
        'Delivering excellence in power infrastructure projects',
        'Building sustainable energy solutions for the future'
      ]
    },
    vision: {
      title: 'Our Vision',
      description: 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
      points: [
        'Regional leadership in sustainable infrastructure development',
        'Global recognition for engineering excellence',
        'Innovation-driven growth in renewable energy sector'
      ]
    }
  }
})

const fetchCoreValuesData = async () => {
  try {
    const response = await coreValuesService.getCoreValuesData()

    // Handle different response structures
    if (response?.data) {
      coreValuesData.value = response.data
    } else if (response) {
      coreValuesData.value = response
    }
  } catch (error) {
    console.error('Failed to fetch core values data:', error)

    // Set default core values data as fallback
    coreValuesData.value = {
      title: 'Core Values',
      subtitle: 'The principles that guide everything we do',
      values: [
        { icon: 'ShieldCheck', title: 'Safety First', description: 'Zero-compromise approach to workplace and operational safety' },
        { icon: 'Award', title: 'Quality Excellence', description: 'ISO 9001:2015 certified processes and international standards' },
        { icon: 'Users', title: 'Customer Focus', description: 'Dedicated to delivering beyond client expectations' },
        { icon: 'Target', title: 'Innovation Driven', description: 'Continuous investment in R&D and cutting-edge technology' }
      ]
    }
  }
}

// Format brand title helper function
const formatBrandTitle = (title) => {
  if (!title) return 'Core Values'
  const words = title.split(' ')
  if (words.length === 1) return title
  const lastWord = words.pop()
  return words.join(' ') + ' <span class="text-industrial-blue">' + lastWord + '</span>'
}

const coreValues = computed(() => {
  // Check if we have API data with values
  const hasApiData = coreValuesData.value &&
                    coreValuesData.value.values &&
                    Array.isArray(coreValuesData.value.values) &&
                    coreValuesData.value.values.length > 0

  if (hasApiData) {
    const cv = coreValuesData.value
    const processedValues = cv.values.map(v => ({
      title: v.title || '',
      description: v.description || '',
      // Handle both string icon names and SVG HTML objects
      icon: typeof v.icon === 'string' && v.icon.includes('<svg')
        ? { template: v.icon }
        : getIconComponent(v.icon || 'ShieldCheck')
    }))

    return {
      title: cv.title || 'Core Values',
      subtitle: cv.subtitle || 'The principles that guide everything we do',
      list: processedValues
    }
  }

  // Default values if no data
  return {
    title: 'Core Values',
    subtitle: 'The principles that guide everything we do',
    list: [
      { icon: getIconComponent('ShieldCheck'), title: 'Safety First', description: 'Zero-compromise approach to workplace and operational safety' },
      { icon: getIconComponent('Award'), title: 'Quality Excellence', description: 'ISO 9001:2015 certified processes and international standards' },
      { icon: getIconComponent('Users'), title: 'Customer Focus', description: 'Dedicated to delivering beyond client expectations' },
      { icon: getIconComponent('Target'), title: 'Innovation Driven', description: 'Continuous investment in R&D and cutting-edge technology' }
    ]
  }
})

const fetchJourneyData = async () => {
  try {
    console.log('Fetching journey data from /api/cms/journey...')
    const response = await journeyService.getJourneyData()
    console.log('Journey response:', response)

    if (response && response.data) {
      journeyData.value = response.data
      console.log('Journey data loaded successfully:', journeyData.value)
    } else if (response) {
      journeyData.value = response
      console.log('Journey data loaded (direct):', journeyData.value)
    } else {
      console.warn('Journey data response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch journey data:', error)
    console.error('Error message:', error.message)

    // Set default journey data as fallback
    journeyData.value = {
      title: 'Our Journey',
      subtitle: 'Four decades of excellence in powering Bangladesh\'s development',
      milestones: [
        { year: '1980', title: 'Foundation', description: 'Influx Group established as a small electrical contractor in Dhaka' },
        { year: '1995', title: 'Expansion', description: 'Entered power transmission and distribution sector' },
        { year: '2005', title: 'Manufacturing', description: 'Started manufacturing transformers and switchgear' },
        { year: '2015', title: 'Renewables', description: 'Diversified into solar and wind energy solutions' },
        { year: '2020', title: 'EPC Leadership', description: 'Became leading EPC contractor for mega projects' },
        { year: '2026', title: 'Regional Hub', description: 'Expanded operations across South Asia' }
      ]
    }
  }
}

const journey = computed(() => {
  if (journeyData.value?.milestones) {
    console.log('Using journey API data:', journeyData.value)
    return journeyData.value
  }

  // Default values if no data
  console.log('Using default journey values')
  return {
    title: 'Our Journey',
    subtitle: 'Four decades of excellence in powering Bangladesh\'s development',
    milestones: [
      { year: '1980', title: 'Foundation', description: 'Influx Group established as a small electrical contractor in Dhaka' },
      { year: '1995', title: 'Expansion', description: 'Entered power transmission and distribution sector' },
      { year: '2005', title: 'Manufacturing', description: 'Started manufacturing transformers and switchgear' },
      { year: '2015', title: 'Renewables', description: 'Diversified into solar and wind energy solutions' },
      { year: '2020', title: 'EPC Leadership', description: 'Became leading EPC contractor for mega projects' },
      { year: '2026', title: 'Regional Hub', description: 'Expanded operations across South Asia' }
    ]
  }
})

const fetchCareerCtaData = async () => {
  try {
    const response = await careerCtaService.getCareerCtaData()
    if (response && response.data) {
      careerCtaData.value = response.data
    } else if (response) {
      careerCtaData.value = response
    }
  } catch (error) {
    console.error('Failed to fetch career CTA data:', error)
    // Set default career CTA data as fallback
    careerCtaData.value = {
      title: 'Join Our <span class="text-yellow-400">Mission</span>',
      description: 'Be part of Bangladesh\'s engineering excellence story',
      button_text: 'Career Opportunities',
      button_link: '/contact'
    }
  }
}

// Career CTA computed property
const careerCta = computed(() => {
  if (careerCtaData.value) {
    return careerCtaData.value
  }
  // Default values
  return {
    title: 'Join Our <span class="text-yellow-400">Mission</span>',
    description: 'Be part of Bangladesh\'s engineering excellence story',
    button_text: 'Career Opportunities',
    button_link: '/contact'
  }
})

onMounted(() => {
  fetchMissionVisionData()
  fetchCoreValuesData()
  fetchJourneyData()
  fetchCareerCtaData()
})
</script>

<style scoped>
/* Dynamic SVG icon styling for Core Values section */
.glass-panel :deep(svg) {
  width: 2.5rem;
  height: 2.5rem;
  color: #1e40af; /* industrial-blue */
  transition: transform 0.3s ease;
}

@media (min-width: 768px) {
  .glass-panel :deep(svg) {
    width: 3rem;
    height: 3rem;
  }
}

/* Icon hover effect */
.glass-panel:hover :deep(svg) {
  transform: scale(1.1);
}

/* Glass panel styling */
.glass-panel {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
}
</style>

<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative py-32 bg-industrial-dark text-white overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-industrial-blue/10 to-transparent"></div>
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div v-motion-slide-visible-left>
          <div class="flex items-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">About Us</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            POWERING <span class="text-industrial-blue">PROGRESS</span><br/>
            <span class="text-white/90">SINCE 1980</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            From humble beginnings to becoming Bangladesh's premier engineering conglomerate, our journey reflects four decades of excellence, innovation, and unwavering commitment to national development.
          </p>
        </div>
      </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-32 bg-white text-industrial-dark">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16">
          <div v-motion-slide-visible-left>
            <div class="flex items-center gap-3 mb-6">
              <Zap class="w-8 h-8 text-industrial-blue" />
              <h2 class="text-4xl font-display font-black uppercase italic">{{ missionVision.mission?.title || 'Our Mission' }}</h2>
            </div>
            <p class="text-lg text-slate-600 leading-relaxed mb-6">
              {{ missionVision.mission?.description || 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.' }}
            </p>
            <ul class="space-y-4">
              <li v-for="(point, index) in missionVision.mission?.points || []" :key="index" class="flex items-start gap-3">
                <CheckCircle class="w-6 h-6 text-industrial-blue flex-shrink-0 mt-1" />
                <span class="text-slate-700">{{ point }}</span>
              </li>
            </ul>
          </div>
          <div v-motion-slide-visible-right>
            <div class="flex items-center gap-3 mb-6">
              <Target class="w-8 h-8 text-industrial-red" />
              <h2 class="text-4xl font-display font-black uppercase italic">{{ missionVision.vision?.title || 'Our Vision' }}</h2>
            </div>
            <p class="text-lg text-slate-600 leading-relaxed mb-6">
              {{ missionVision.vision?.description || 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.' }}
            </p>
            <ul class="space-y-4">
              <li v-for="(point, index) in missionVision.vision?.points || []" :key="index" class="flex items-start gap-3">
                <CheckCircle class="w-6 h-6 text-industrial-red flex-shrink-0 mt-1" />
                <span class="text-slate-700">{{ point }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Timeline -->
    <section class="py-32 bg-industrial-light">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic mb-6">
            {{ journey.title?.split(' ')[0] || 'Our' }} <span class="text-industrial-blue">{{ journey.title?.split(' ').slice(1).join(' ') || 'Journey' }}</span>
          </h2>
          <p class="text-slate-600 text-lg max-w-2xl mx-auto">
            {{ journey.subtitle || 'Four decades of excellence in powering Bangladesh\'s development' }}
          </p>
        </div>

        <div class="relative">
          <!-- Timeline Line -->
          <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-industrial-blue/20"></div>

          <!-- Timeline Items -->
          <div class="space-y-16">
            <div
              v-for="(item, index) in journey.milestones"
              :key="index"
              class="relative flex items-center"
              :class="index % 2 === 0 ? 'flex-row' : 'flex-row-reverse'"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <!-- Content -->
              <div class="w-5/12" :class="index % 2 === 0 ? 'text-right pr-12' : 'text-left pl-12'">
                <div class="bg-white p-8 rounded-lg shadow-xl hover:shadow-2xl transition-shadow">
                  <div class="text-industrial-blue font-black text-2xl mb-2">{{ item.year }}</div>
                  <h3 class="text-xl font-bold mb-3">{{ item.title }}</h3>
                  <p class="text-slate-600">{{ item.description }}</p>
                </div>
              </div>

              <!-- Center Dot -->
              <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-industrial-blue rounded-full border-4 border-white shadow-lg"></div>

              <!-- Empty Space -->
              <div class="w-5/12"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Core Values -->
      <section class="py-20 md:py-32 bg-industrial-dark text-white">
          <div class="max-w-7xl mx-auto px-6">
              <div class="text-center mb-16" v-motion-slide-visible-bottom>
                  <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-white" v-html="formatBrandTitle(coreValues.title)">
                  </h2>
                  <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                      {{ coreValues.subtitle }}
                  </p>
              </div>

              <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                  <div
                      v-for="(value, index) in coreValues.list"
                      :key="index"
                      class="glass-panel p-6 md:p-8 rounded-lg hover:bg-industrial-blue/10 transition-colors group"
                      v-motion-slide-visible-bottom
                      :delay="index * 100"
                  >
                      <!-- Icon - SVG template or component -->
                      <div v-if="value.icon?.template" v-html="value.icon.template" class="w-10 h-10 md:w-12 md:h-12 text-industrial-blue mb-4 md:mb-6 group-hover:scale-110 transition-transform"></div>
                      <component v-else :is="value.icon" class="w-10 h-10 md:w-12 md:h-12 text-industrial-blue mb-4 md:mb-6 group-hover:scale-110 transition-transform" />
                      <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4 text-white">{{ value.title }}</h3>
                      <p class="text-slate-400 text-xs md:text-sm leading-relaxed">{{ value.description }}</p>
                  </div>
              </div>
          </div>
      </section>






    <!-- Certifications -->
    <section class="py-32 bg-white text-industrial-dark">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic mb-6">
            Certifications & <span class="text-industrial-blue">Standards</span>
          </h2>
          <p class="text-slate-600 text-lg max-w-2xl mx-auto">
            Internationally recognized certifications ensuring quality and safety
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
          <div
            v-for="(cert, index) in certifications"
            :key="index"
            class="bg-industrial-light p-6 rounded-lg text-center hover:bg-industrial-blue hover:text-white transition-all group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="font-black uppercase text-xs tracking-wider">{{ cert }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-industrial-blue text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8" v-html="careerCta.title">
        </h2>
        <p class="text-xl mb-12 text-industrial-100">
          {{ careerCta.description }}
        </p>
        <a :href="careerCta.button_link || '/contact'" class="inline-flex bg-white text-industrial-blue px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
          {{ careerCta.button_text }}
        </a>
      </div>
    </section>
  </div>
</template>
