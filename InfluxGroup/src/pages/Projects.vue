<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { MapPin, Zap, Building2, Calendar, Filter, ArrowRight } from 'lucide-vue-next'
import { projectService } from '../services/content'
import { API_CONFIG } from '../config/api'

const router = useRouter()
const activeFilter = ref('all')
const projects = ref([])
const categories = ref([])
const isLoading = ref(true)

const filters = computed(() => {
  return [
    { id: 'all', name: 'All Projects' },
    ...(categories.value || []).map(cat => ({
      id: cat.slug,
      name: cat.name
    }))
  ]
})

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1466611653911-95282fc3656b?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const fetchProjects = async () => {
  try {
    isLoading.value = true
    const response = await projectService.getProjects({ limit: 100 })
    projects.value = response || []
  } catch (error) {
    console.error('Failed to fetch projects:', error)
  } finally {
    isLoading.value = false
  }
}

const fetchCategories = async () => {
  try {
    const response = await projectService.getProjectCategories()
    categories.value = response
  } catch (error) {
    console.error('Failed to fetch project categories:', error)
  }
}

const filteredProjects = computed(() => {
  if (activeFilter.value === 'all') return projects.value || []
  return (projects.value || []).filter(p => {
    // Check if it matches by category slug, category name, or type
    return p.category === activeFilter.value ||
           p.projectCategory?.slug === activeFilter.value ||
           p.projectCategory?.name === activeFilter.value ||
           p.type === activeFilter.value
  })
})

const viewProjectDetails = (project) => {
  if (project.slug) {
    router.push(`/projects/${project.slug}`)
  }
}

onMounted(async () => {
  await Promise.all([fetchProjects(), fetchCategories()])
})
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
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">Our Projects</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            BUILDING <span class="text-industrial-blue">BANGLADESH</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            From mega power projects to renewable energy installations, we deliver engineering excellence that powers the nation.
          </p>
        </div>
      </div>
    </section>

    <!-- Filter Section -->
    <section class="py-12 bg-white border-b sticky top-20 z-30 shadow-md">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap gap-4 justify-center">
          <button
            v-for="filter in filters"
            :key="filter.id"
            @click="activeFilter = filter.id"
            class="flex items-center gap-2 px-6 py-3 rounded-sm font-bold uppercase text-xs tracking-wider transition-all"
            :class="activeFilter === filter.id ? 'bg-industrial-blue text-white' : 'bg-industrial-light text-industrial-dark hover:bg-industrial-blue/10'"
          >
            <Filter class="w-4 h-4" />
            {{ filter.name }}
          </button>
        </div>
      </div>
    </section>

    <!-- Projects Grid -->
    <section class="py-20 min-h-[400px]">
      <div class="max-w-7xl mx-auto px-6">
        <div v-if="isLoading" class="flex flex-col items-center justify-center py-20 gap-4">
          <div class="w-12 h-12 border-4 border-industrial-blue border-t-transparent rounded-full animate-spin"></div>
          <p class="text-industrial-dark font-bold uppercase tracking-widest text-xs">Loading Projects...</p>
        </div>

        <div v-else-if="filteredProjects.length === 0" class="text-center py-20">
          <p class="text-xl text-slate-500 font-medium">No projects found in this category.</p>
        </div>

        <div v-else class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="(project, index) in (filteredProjects || [])"
            :key="project.id"
            class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <!-- Image -->
            <div class="relative h-64 overflow-hidden">
              <img
                :src="getImageUrl(project.image)"
                :alt="project.title"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/80 to-transparent"></div>

              <!-- Capacity Badge -->
              <div v-if="project.capacity" class="absolute top-4 right-4 bg-industrial-blue text-white px-4 py-2 rounded-sm">
                <div class="text-xs font-black uppercase tracking-wider">{{ project.capacity }}</div>
              </div>

              <!-- Category Badge -->
              <div class="absolute top-4 left-4 bg-industrial-red text-white px-3 py-1 rounded-full text-xs font-bold uppercase">
                {{ project.category || 'Project' }}
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <h3 class="text-xl font-display font-black uppercase italic mb-3 group-hover:text-industrial-blue transition-colors">
                {{ project.title }}
              </h3>

              <!-- Description/Body Preview -->
              <div v-if="project.description || project.body" class="text-slate-600 text-sm mb-4 leading-relaxed line-clamp-2">
                {{ project.description || project.body }}
              </div>

              <!-- Location -->
              <div class="flex items-center gap-2 text-slate-600 mb-4">
                <MapPin class="w-4 h-4" />
                <span class="text-sm font-medium">{{ project.location || 'Bangladesh' }}</span>
              </div>

              <!-- Project Details -->
              <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                  <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Status / Completion</div>
                  <div class="flex items-center gap-2 text-sm font-bold">
                    <Calendar class="w-4 h-4 text-industrial-blue" />
                    {{ project.completion || project.status }}
                  </div>
                </div>
                <div>
                  <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Client</div>
                  <div class="text-sm font-bold truncate">{{ project.client || 'N/A' }}</div>
                </div>
              </div>

              <!-- Scope -->
              <div v-if="project.scope && project.scope.length" class="mb-6">
                <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2">Project Scope</div>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="(scope, idx) in project.scope.slice(0, 3)"
                    :key="idx"
                    class="bg-industrial-light text-industrial-dark px-3 py-1 rounded text-[10px] font-bold uppercase"
                  >
                    {{ scope }}
                  </span>
                </div>
              </div>

              <!-- CTA -->
              <button
                @click="viewProjectDetails(project)"
                class="w-full bg-industrial-blue text-white py-3 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-red transition-colors flex items-center justify-center gap-2 group-hover:gap-4"
              >
                View Details <ArrowRight class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 text-center">
          <div v-motion-slide-visible-bottom>
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">50+</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Projects Completed</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="100">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">5 GW</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Total Capacity</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="200">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">99.9%</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">On-Time Delivery</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="300">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">25+</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Years Experience</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-industrial-blue text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Start Your <span class="text-yellow-400">Project</span>
        </h2>
        <p class="text-xl mb-12 text-industrial-100">
          Let's discuss how we can power your next project
        </p>
        <button class="bg-white text-industrial-blue px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
          Get In Touch
        </button>
      </div>
    </section>
  </div>
</template>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
