<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { Building2, Zap, Factory, Wrench, ArrowRight } from 'lucide-vue-next'
import { solutionService } from '../services/content'
import { API_CONFIG } from '../config/api'

const router = useRouter()
const solutions = ref([])
const isLoading = ref(true)

const solutionIcons = {
  'EPC Solutions': Zap,
  'MEP Solutions': Building2,
  'Industrial Solutions': Factory,
  'Maintenance Solutions': Wrench,
  default: Building2
}

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const fetchSolutions = async () => {
  try {
    isLoading.value = true
    const response = await solutionService.getSolutions()
    solutions.value = response || []
  } catch (error) {
    console.error('Failed to fetch solutions:', error)
  } finally {
    isLoading.value = false
  }
}

const viewSolutionDetails = (solution) => {
  if (solution.slug) {
    router.push(`/solutions/${solution.slug}`)
  }
}

onMounted(fetchSolutions)

const industries = [
  { name: 'Power Generation', icon: Zap },
  { name: 'Textile', icon: Factory },
  { name: 'Pharmaceuticals', icon: Building2 },
  { name: 'Construction', icon: Building2 },
  { name: 'Food Processing', icon: Factory },
  { name: 'Telecom', icon: Zap }
]
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
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">Our Solutions</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            ENGINEERING <span class="text-industrial-blue">MASTERY</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            Tailored solutions designed to meet the unique challenges of power infrastructure across diverse industries.
          </p>
        </div>
      </div>
    </section>

    <!-- Solutions Grid -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div v-if="isLoading" class="flex flex-col items-center justify-center py-20 gap-4">
          <div class="w-12 h-12 border-4 border-industrial-blue border-t-transparent rounded-full animate-spin"></div>
          <p class="text-industrial-dark font-bold uppercase tracking-widest text-xs">Loading Solutions...</p>
        </div>

        <div v-else-if="solutions.length === 0" class="text-center py-20">
          <p class="text-xl text-slate-500 font-medium">No solutions available at the moment.</p>
        </div>

        <div v-else class="grid md:grid-cols-2 gap-8">
          <div
            v-for="(solution, index) in solutions"
            :key="solution.id || index"
            class="group rounded-lg overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 cursor-pointer"
            v-motion-slide-visible-bottom
            :delay="index * 100"
            @click="viewSolutionDetails(solution)"
          >
            <div class="grid md:grid-cols-2">
              <!-- Image Side -->
              <div class="relative h-64 md:h-auto">
                <img
                  :src="getImageUrl(solution.image)"
                  :alt="solution.title"
                  class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark/80 to-transparent md:bg-gradient-to-t"></div>
                <div class="absolute top-4 left-4 bg-industrial-blue text-white p-3 rounded-lg">
                  <component :is="solutionIcons[solution.title] || solutionIcons.default" class="w-6 h-6" />
                </div>
              </div>

              <!-- Content Side -->
              <div class="p-8 flex flex-col">
                <h3 class="text-2xl font-display font-black uppercase italic mb-4 group-hover:text-industrial-blue transition-colors">
                  {{ solution.title }}
                </h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                  {{ solution.description }}
                </p>

                <div v-if="solution.components && solution.components.length" class="mb-6">
                  <div class="text-xs font-black uppercase tracking-wider text-slate-500 mb-3">Core Components</div>
                  <div class="space-y-2">
                    <div
                      v-for="(component, idx) in solution.components.slice(0, 4)"
                      :key="idx"
                      class="flex items-center gap-2 text-sm text-slate-700"
                    >
                      <div class="w-1.5 h-1.5 rounded-full bg-industrial-blue"></div>
                      {{ component }}
                    </div>
                  </div>
                </div>

                <div class="mt-auto">
                  <div v-if="solution.applications && solution.applications.length" class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Applications</div>
                  <div v-if="solution.applications && solution.applications.length" class="flex flex-wrap gap-2 mb-6">
                    <span
                      v-for="(app, idx) in solution.applications.slice(0, 3)"
                      :key="idx"
                      class="bg-industrial-light text-industrial-dark px-3 py-1 rounded text-xs font-medium"
                    >
                      {{ app }}
                    </span>
                  </div>
                  <button class="w-full bg-industrial-blue text-white py-3 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-red transition-colors flex items-center justify-center gap-2 group-hover:gap-4">
                    Learn More <ArrowRight class="w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Industries Served -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic mb-6">
            Industries We <span class="text-industrial-blue">Serve</span>
          </h2>
          <p class="text-slate-400 text-lg max-w-2xl mx-auto">
            Delivering specialized solutions across diverse sectors
          </p>
        </div>

        <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6">
          <div
            v-for="(industry, index) in industries"
            :key="index"
            class="glass-panel p-6 rounded-lg text-center hover:bg-industrial-blue/10 transition-colors group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <component :is="industry.icon" class="w-12 h-12 text-industrial-blue mx-auto mb-4 group-hover:scale-110 transition-transform" />
            <div class="font-bold uppercase text-xs tracking-wider">{{ industry.name }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Case Study CTA -->
    <section class="py-32 bg-industrial-blue text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Need a Custom <span class="text-yellow-400">Solution?</span>
        </h2>
        <p class="text-xl mb-12 text-industrial-100">
          Our engineering team can design tailored solutions for your specific requirements
        </p>
        <button class="bg-white text-industrial-blue px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
          Discuss Your Project
        </button>
      </div>
    </section>
  </div>
</template>
