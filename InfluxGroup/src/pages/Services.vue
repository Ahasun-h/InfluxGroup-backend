<script setup>
import { ref } from 'vue'
import { Cog, Wrench, Users, Zap, CheckCircle, ArrowRight } from 'lucide-vue-next'

const services = [
  {
    icon: Cog,
    title: 'EPC Contracting',
    description: 'Full-scope Engineering, Procurement, and Construction services for power infrastructure projects',
    features: ['Turnkey Solutions', 'Project Management', 'Quality Assurance', 'Safety Compliance'],
    link: '/solutions'
  },
  {
    icon: Wrench,
    title: 'Maintenance Services',
    description: 'Comprehensive maintenance and support for all power systems and equipment',
    features: ['24/7 Emergency Support', 'Preventive Maintenance', 'Condition Monitoring', 'Spare Parts Supply'],
    link: '/contact'
  },
  {
    icon: Users,
    title: 'Technical Training',
    description: 'Professional training programs for engineers and technicians in power sector',
    features: ['Hands-on Training', 'Certification Programs', 'Custom Courses', 'On-site Training'],
    link: '/contact'
  },
  {
    icon: Zap,
    title: 'Testing & Commissioning',
    description: 'Complete testing and commissioning services for power systems and equipment',
    features: ['Type Testing', 'Site Testing', 'Commissioning', 'Performance Evaluation'],
    link: '/contact'
  }
]

const serviceProcess = [
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
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">Our Services</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            COMPREHENSIVE <span class="text-industrial-blue">SOLUTIONS</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            End-to-end services from concept to commissioning, ensuring your power infrastructure operates at peak performance.
          </p>
        </div>
      </div>
    </section>

    <!-- Main Services -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-8">
          <div
            v-for="(service, index) in services"
            :key="index"
            class="group p-8 rounded-lg border-2 border-slate-200 hover:border-industrial-blue transition-all duration-500 hover:shadow-2xl"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="flex items-start gap-6">
              <div class="w-16 h-16 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-industrial-red transition-colors">
                <component :is="service.icon" class="w-8 h-8 text-white" />
              </div>
              <div class="flex-1">
                <h3 class="text-2xl font-display font-black uppercase italic mb-4 group-hover:text-industrial-blue transition-colors">
                  {{ service.title }}
                </h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                  {{ service.description }}
                </p>
                <div class="mb-6">
                  <div class="text-xs font-black uppercase tracking-wider text-slate-500 mb-3">Key Features</div>
                  <div class="space-y-2">
                    <div
                      v-for="(feature, idx) in service.features"
                      :key="idx"
                      class="flex items-center gap-2 text-sm text-slate-700"
                    >
                      <CheckCircle class="w-4 h-4 text-industrial-blue flex-shrink-0" />
                      {{ feature }}
                    </div>
                  </div>
                </div>
                <button class="text-industrial-blue font-bold uppercase text-xs tracking-wider flex items-center gap-2 group-hover:gap-4 transition-all">
                  Learn More <ArrowRight class="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Service Process -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic mb-6">
            Our <span class="text-industrial-blue">Process</span>
          </h2>
          <p class="text-slate-400 text-lg max-w-2xl mx-auto">
            A systematic approach to delivering excellence in every project
          </p>
        </div>

        <div class="grid md:grid-cols-4 gap-8">
          <div
            v-for="(step, index) in serviceProcess"
            :key="index"
            class="text-center"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="text-6xl font-display font-black text-industrial-blue/30 mb-4">{{ step.step }}</div>
            <h3 class="text-xl font-bold mb-3">{{ step.title }}</h3>
            <p class="text-slate-400 text-sm leading-relaxed">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-32 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16 items-center">
          <div v-motion-slide-visible-left>
            <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] mb-8">
              Why Choose <span class="text-industrial-blue">Influx Group?</span>
            </h2>
            <div class="space-y-6">
              <div v-for="n in 4" :key="n" class="flex items-start gap-4">
                <div class="w-12 h-12 bg-industrial-blue rounded-full flex items-center justify-center flex-shrink-0">
                  <CheckCircle class="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 class="font-bold text-lg mb-2">45+ Years of Excellence</h3>
                  <p class="text-slate-600 text-sm">Decades of experience in delivering power infrastructure solutions across Bangladesh.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="relative" v-motion-slide-visible-right>
            <img
              src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200"
              class="rounded-lg shadow-2xl"
              alt="Service Team"
            />
            <div class="absolute -bottom-8 -left-8 bg-industrial-blue text-white p-8 rounded-lg shadow-xl">
              <div class="text-4xl font-display font-black mb-2">24/7</div>
              <div class="text-xs font-black uppercase tracking-widest">Support Available</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-industrial-blue text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Ready to Get <span class="text-yellow-400">Started?</span>
        </h2>
        <p class="text-xl mb-12 text-industrial-100">
          Contact our team to discuss your power infrastructure needs
        </p>
        <button class="bg-white text-industrial-blue px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
          Request Consultation
        </button>
      </div>
    </section>
  </div>
</template>
