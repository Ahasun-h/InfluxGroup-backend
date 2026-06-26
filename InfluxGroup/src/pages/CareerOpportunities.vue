<script setup>
import { ref, onMounted, computed } from 'vue'
import { careerService } from '../services/content'
import {
  Briefcase,
  Building2,
  MapPin,
  Calendar,
  DollarSign,
  Send,
  ArrowRight,
  CheckCircle,
  Mail,
  Phone,
  Map
} from 'lucide-vue-next'

const jobs = ref([])
const isLoading = ref(true)
const selectedJob = ref(null)

const fetchJobs = async () => {
  try {
    isLoading.value = true
    const data = await careerService.getJobs()
    jobs.value = data || []
  } catch (error) {
    console.error('Failed to fetch jobs:', error)
    // Set default job listings if API fails
    jobs.value = [
      {
        title: 'Senior Electrical Engineer',
        department: 'Engineering',
        location: 'Dhaka',
        type: 'Full-time',
        experience: '5+ years',
        salary: 'Competitive',
        description: 'Lead electrical engineering projects for power infrastructure and renewable energy systems. Design and implement electrical systems for industrial and commercial projects.',
        requirements: [
          'B.Sc. in Electrical Engineering',
          '5+ years experience in power sector',
          'Knowledge of IEEE standards',
          'Experience with AutoCAD and ETAP',
          'Strong project management skills'
        ],
        responsibilities: [
          'Design electrical systems for power infrastructure',
          'Lead engineering team in project execution',
          'Ensure compliance with safety standards',
          'Coordinate with clients and stakeholders',
          'Provide technical expertise and guidance'
        ],
        benefits: [
          'Competitive salary package',
          'Health and life insurance',
          'Provident fund and gratuity',
          'Performance bonuses',
          'Professional development opportunities'
        ]
      },
      {
        title: 'Project Manager - EPC',
        department: 'Project Management',
        location: 'Chittagong',
        type: 'Full-time',
        experience: '7+ years',
        salary: 'Negotiable',
        description: 'Manage large-scale EPC projects from concept to commissioning in power infrastructure. Lead multidisciplinary teams and ensure successful project delivery.',
        requirements: [
          'B.Sc. in Engineering',
          '7+ years EPC project experience',
          'PMP certification preferred',
          'Strong leadership skills',
          'Experience in power sector projects'
        ],
        responsibilities: [
          'Overall project management and coordination',
          'Resource planning and allocation',
          'Stakeholder management and communication',
          'Budget control and cost management',
          'Quality assurance and timeline adherence'
        ],
        benefits: [
          'Leadership role with growth potential',
          'Competitive compensation',
          'Company car and allowances',
          'International training opportunities',
          'Performance-based bonuses'
        ]
      },
      {
        title: 'Maintenance Engineer',
        department: 'Operations',
        location: 'Dhaka',
        type: 'Full-time',
        experience: '3+ years',
        salary: 'Competitive',
        description: 'Provide maintenance and technical support for power systems and equipment nationwide. Ensure optimal performance and minimal downtime.',
        requirements: [
          'B.Sc. in Electrical/Mechanical Engineering',
          '3+ years maintenance experience',
          'Willingness to travel nationwide',
          'Strong problem-solving skills',
          'Knowledge of power systems'
        ],
        responsibilities: [
          'Preventive and corrective maintenance',
          'Emergency response and troubleshooting',
          'Technical support to clients',
          'Maintenance schedule planning',
          'Equipment performance monitoring'
        ],
        benefits: [
          'Field allowance and travel benefits',
          'Skill development programs',
          'Health and safety coverage',
          'Career advancement opportunities',
          'Team-based work environment'
        ]
      }
    ]
  } finally {
    isLoading.value = false
  }
}

const openJobModal = (job) => {
  selectedJob.value = job
  document.body.style.overflow = 'hidden'
}

const closeJobModal = () => {
  selectedJob.value = null
  document.body.style.overflow = 'auto'
}

onMounted(fetchJobs)

const benefits = []
</script>

<template>
  <div class="min-h-screen bg-industrial-light">
    <!-- Hero Section -->
    <section class="relative py-20 md:py-32 bg-gradient-to-br from-industrial-dark to-industrial-blue text-white overflow-hidden">
      <!-- Background pattern -->
      <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
      </div>

      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center" v-motion-slide-visible-bottom>
          <div class="flex items-center justify-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] text-[10px] md:text-xs">Join Our Team</span>
            <div class="h-px w-12 bg-industrial-blue"></div>
          </div>
          <h1 class="text-4xl md:text-6xl lg:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            Career <span class="text-industrial-blue">Opportunities</span>
          </h1>
          <p class="text-lg md:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed mb-12">
            Build your career with Bangladesh's leading engineering conglomerate. Join our team of professionals powering the nation's infrastructure development.
          </p>

          <!-- Quick Stats -->
          <div class="grid md:grid-cols-3 gap-6 md:gap-8 max-w-4xl mx-auto">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-6">
              <div class="text-4xl md:text-5xl font-display font-black text-industrial-blue mb-2">45+</div>
              <div class="text-slate-300 text-sm">Years of Excellence</div>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-6">
              <div class="text-4xl md:text-5xl font-display font-black text-industrial-blue mb-2">500+</div>
              <div class="text-slate-300 text-sm">Technical Professionals</div>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-6">
              <div class="text-4xl md:text-5xl font-display font-black text-industrial-blue mb-2">15+</div>
              <div class="text-slate-300 text-sm">Current Openings</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Open Positions Section -->
    <section class="py-20 md:py-32 bg-industrial-light">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <div class="flex items-center justify-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] text-[10px] md:text-xs">Current Openings</span>
            <div class="h-px w-12 bg-industrial-blue"></div>
          </div>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-industrial-dark">
            Available <span class="text-industrial-blue">Positions</span>
          </h2>
          <p class="text-slate-600 text-lg max-w-3xl mx-auto">
            Explore our current job openings and find the perfect opportunity to advance your career
          </p>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="flex flex-col items-center justify-center py-20">
          <div class="w-12 h-12 border-4 border-industrial-blue border-t-transparent rounded-full animate-spin mb-4"></div>
          <p class="text-industrial-dark font-bold uppercase tracking-widest text-xs">Loading Positions...</p>
        </div>

        <!-- Empty State -->
        <div v-else-if="jobs.length === 0" class="text-center py-20 bg-white rounded-xl">
          <Briefcase class="w-16 h-16 text-slate-400 mx-auto mb-4" />
          <h3 class="text-2xl font-display font-black uppercase italic mb-3 text-industrial-dark">No Current Openings</h3>
          <p class="text-slate-600 mb-8">Check back soon for new career opportunities</p>
        </div>

        <!-- Job Listings -->
        <div v-else class="space-y-6">
          <div
            v-for="(job, index) in jobs"
            :key="index"
            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group cursor-pointer"
            @click="openJobModal(job)"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="p-6 md:p-8">
              <div class="grid md:grid-cols-12 gap-6 items-center">
                <!-- Icon & Type -->
                <div class="md:col-span-1 flex items-start justify-center md:justify-start">
                  <div class="w-14 h-14 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <Briefcase class="w-7 h-7 text-white" />
                  </div>
                </div>

                <!-- Job Details -->
                <div class="md:col-span-7">
                  <div class="flex items-center gap-3 mb-3">
                    <span class="bg-industrial-red text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                      {{ job.type || 'Full-time' }}
                    </span>
                    <span class="text-slate-500 text-xs">{{ job.posted_date || 'Recently posted' }}</span>
                  </div>
                  <h3 class="text-xl md:text-2xl font-display font-black uppercase italic mb-3 text-industrial-dark group-hover:text-industrial-blue transition-colors">
                    {{ job.title }}
                  </h3>
                  <p class="text-slate-600 leading-relaxed line-clamp-2 mb-4">{{ job.description }}</p>

                  <!-- Quick Info Grid -->
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="flex items-center gap-2 text-slate-500">
                      <Building2 class="w-4 h-4" />
                      <span class="text-xs">{{ job.department }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-500">
                      <MapPin class="w-4 h-4" />
                      <span class="text-xs">{{ job.location }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-500">
                      <Calendar class="w-4 h-4" />
                      <span class="text-xs">{{ job.experience }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-500">
                      <DollarSign class="w-4 h-4" />
                      <span class="text-xs">{{ job.salary }}</span>
                    </div>
                  </div>
                </div>

                <!-- Apply Button -->
                <div class="md:col-span-4 flex items-center justify-center md:justify-end">
                  <button class="bg-industrial-blue hover:bg-industrial-red text-white px-6 md:px-8 py-3 rounded-lg font-bold uppercase tracking-widest text-[10px] md:text-xs transition-all flex items-center gap-2 group-hover:gap-4">
                    View Details <ArrowRight class="w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact CTA Section -->
    <section class="py-20 md:py-32 bg-white">
      <div class="max-w-4xl mx-auto px-6 text-center" v-motion-slide-visible-bottom>
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8 text-industrial-dark">
          Ready to <span class="text-industrial-blue">Apply?</span>
        </h2>
        <p class="text-lg text-slate-600 mb-12 max-w-2xl mx-auto">
          Send your CV and cover letter to our HR team. We review all applications and contact shortlisted candidates within 2 weeks.
        </p>

        <div class="grid md:grid-cols-2 gap-6 max-w-2xl mx-auto mb-8">
          <a
            href="mailto:careers@influxgroup.com"
            class="bg-industrial-blue hover:bg-industrial-red text-white p-6 rounded-xl transition-all group"
          >
            <Mail class="w-8 h-8 mx-auto mb-3" />
            <div class="font-bold mb-1">Email Your CV</div>
            <div class="text-sm opacity-80">careers@influxgroup.com</div>
          </a>
          <a
            href="tel:+88029876543"
            class="bg-industrial-light hover:bg-industrial-blue hover:text-white text-industrial-dark p-6 rounded-xl transition-all group"
          >
            <Phone class="w-8 h-8 mx-auto mb-3" />
            <div class="font-bold mb-1">Call HR Department</div>
            <div class="text-sm opacity-70 group-hover:opacity-100">+880 2 987 6543</div>
          </a>
        </div>

        <div class="flex items-center justify-center gap-2 text-slate-500 text-sm">
          <Map class="w-4 h-4" />
          <span>Head Office: Dhaka, Bangladesh</span>
        </div>
      </div>
    </section>

    <!-- Job Detail Modal -->
    <Transition
      enter-active-class="transition-all duration-300"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition-all duration-200"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-if="selectedJob"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-8"
        @click.self="closeJobModal"
      >
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="closeJobModal"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
          <!-- Modal Header -->
          <div class="sticky top-0 bg-gradient-to-r from-industrial-dark to-industrial-blue text-white p-6 md:p-8 z-10">
            <button @click="closeJobModal" class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
              ✕
            </button>
            <div class="flex items-start gap-4">
              <div class="w-16 h-16 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                <Briefcase class="w-8 h-8 text-white" />
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                  <span class="bg-industrial-red text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                    {{ selectedJob.type || 'Full-time' }}
                  </span>
                </div>
                <h2 class="text-2xl md:text-3xl font-display font-black uppercase italic leading-tight">{{ selectedJob.title }}</h2>
              </div>
            </div>
          </div>

          <!-- Modal Content -->
          <div class="p-6 md:p-8">
            <!-- Job Description -->
            <div class="mb-8">
              <h3 class="text-xl font-display font-black uppercase italic mb-4 text-industrial-dark">Job Description</h3>
              <p class="text-slate-600 leading-relaxed">{{ selectedJob.description }}</p>
            </div>

            <!-- Requirements -->
            <div v-if="selectedJob.requirements && selectedJob.requirements.length" class="mb-8">
              <h3 class="text-xl font-display font-black uppercase italic mb-4 text-industrial-dark">Requirements</h3>
              <ul class="space-y-3">
                <li v-for="(req, idx) in selectedJob.requirements" :key="idx" class="flex items-start gap-3">
                  <CheckCircle class="w-5 h-5 text-industrial-blue flex-shrink-0 mt-0.5" />
                  <span class="text-slate-600">{{ req }}</span>
                </li>
              </ul>
            </div>

            <!-- Responsibilities -->
            <div v-if="selectedJob.responsibilities && selectedJob.responsibilities.length" class="mb-8">
              <h3 class="text-xl font-display font-black uppercase italic mb-4 text-industrial-dark">Responsibilities</h3>
              <ul class="space-y-3">
                <li v-for="(resp, idx) in selectedJob.responsibilities" :key="idx" class="flex items-start gap-3">
                  <div class="w-2 h-2 rounded-full bg-industrial-blue flex-shrink-0 mt-2"></div>
                  <span class="text-slate-600">{{ resp }}</span>
                </li>
              </ul>
            </div>

            <!-- Benefits -->
            <div v-if="selectedJob.benefits && selectedJob.benefits.length" class="mb-8">
              <h3 class="text-xl font-display font-black uppercase italic mb-4 text-industrial-dark">Benefits & Perks</h3>
              <div class="grid md:grid-cols-2 gap-3">
                <div v-for="(benefit, idx) in selectedJob.benefits" :key="idx" class="flex items-center gap-3 bg-industrial-light p-3 rounded-lg">
                  <CheckCircle class="w-5 h-5 text-industrial-blue flex-shrink-0" />
                  <span class="text-slate-700 text-sm">{{ benefit }}</span>
                </div>
              </div>
            </div>

            <!-- Quick Info -->
            <div class="bg-industrial-light p-4 rounded-xl">
              <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                  <div class="text-xs text-slate-500 mb-1">Department</div>
                  <div class="font-bold text-industrial-dark flex items-center gap-2">
                    <Building2 class="w-4 h-4" />
                    {{ selectedJob.department }}
                  </div>
                </div>
                <div>
                  <div class="text-xs text-slate-500 mb-1">Location</div>
                  <div class="font-bold text-industrial-dark flex items-center gap-2">
                    <MapPin class="w-4 h-4" />
                    {{ selectedJob.location }}
                  </div>
                </div>
                <div>
                  <div class="text-xs text-slate-500 mb-1">Experience</div>
                  <div class="font-bold text-industrial-dark flex items-center gap-2">
                    <Calendar class="w-4 h-4" />
                    {{ selectedJob.experience }}
                  </div>
                </div>
                <div>
                  <div class="text-xs text-slate-500 mb-1">Salary</div>
                  <div class="font-bold text-industrial-dark flex items-center gap-2">
                    <DollarSign class="w-4 h-4" />
                    {{ selectedJob.salary }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Apply Button -->
            <div class="mt-8">
              <a
                href="mailto:careers@influxgroup.com?subject=Application for {{ selectedJob.title }}"
                class="w-full bg-industrial-blue hover:bg-industrial-red text-white py-4 rounded-xl font-bold uppercase tracking-widest text-xs transition-all flex items-center justify-center gap-3"
              >
                <Send class="w-5 h-5" />
                Apply for this Position
              </a>
            </div>
          </div>
        </div>
      </div>
    </Transition>
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