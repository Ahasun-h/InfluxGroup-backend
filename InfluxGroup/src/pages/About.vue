<script setup>
import { ref } from 'vue'
import { Award, Users, Target, Zap, ShieldCheck, CheckCircle } from 'lucide-vue-next'

const timeline = ref([
  {
    year: '1980',
    title: 'Foundation',
    description: 'Influx Group established as a small electrical contractor in Dhaka'
  },
  {
    year: '1995',
    title: 'Expansion',
    description: 'Entered power transmission and distribution sector'
  },
  {
    year: '2005',
    title: 'Manufacturing',
    description: 'Started manufacturing transformers and switchgear'
  },
  {
    year: '2015',
    title: 'Renewables',
    description: 'Diversified into solar and wind energy solutions'
  },
  {
    year: '2020',
    title: 'EPC Leadership',
    description: 'Became leading EPC contractor for mega projects'
  },
  {
    year: '2026',
    title: 'Regional Hub',
    description: 'Expanded operations across South Asia'
  }
])

const values = ref([
  {
    icon: ShieldCheck,
    title: 'Safety First',
    description: 'Zero-compromise approach to workplace and operational safety'
  },
  {
    icon: Award,
    title: 'Quality Excellence',
    description: 'ISO 9001:2015 certified processes and international standards'
  },
  {
    icon: Users,
    title: 'Customer Focus',
    description: 'Dedicated to delivering beyond client expectations'
  },
  {
    icon: Target,
    title: 'Innovation Driven',
    description: 'Continuous investment in R&D and cutting-edge technology'
  }
])

const certifications = ref([
  'ISO 9001:2015',
  'ISO 14001:2015',
  'ISO 45001:2018',
  'IEC 60076',
  'IEEE Standards',
  'BPDB Approved'
])
</script>

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
              <h2 class="text-4xl font-display font-black uppercase italic">Our Mission</h2>
            </div>
            <p class="text-lg text-slate-600 leading-relaxed mb-6">
              To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh's industrial growth and infrastructure development.
            </p>
            <ul class="space-y-4">
              <li v-for="n in 3" :key="n" class="flex items-start gap-3">
                <CheckCircle class="w-6 h-6 text-industrial-blue flex-shrink-0 mt-1" />
                <span class="text-slate-700">Powering Bangladesh's development through innovative energy solutions</span>
              </li>
            </ul>
          </div>
          <div v-motion-slide-visible-right>
            <div class="flex items-center gap-3 mb-6">
              <Target class="w-8 h-8 text-industrial-red" />
              <h2 class="text-4xl font-display font-black uppercase italic">Our Vision</h2>
            </div>
            <p class="text-lg text-slate-600 leading-relaxed mb-6">
              To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.
            </p>
            <ul class="space-y-4">
              <li v-for="n in 3" :key="n" class="flex items-start gap-3">
                <CheckCircle class="w-6 h-6 text-industrial-red flex-shrink-0 mt-1" />
                <span class="text-slate-700">Regional leadership in sustainable infrastructure development</span>
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
            Our <span class="text-industrial-blue">Journey</span>
          </h2>
          <p class="text-slate-600 text-lg max-w-2xl mx-auto">
            Four decades of excellence in powering Bangladesh's development
          </p>
        </div>

        <div class="relative">
          <!-- Timeline Line -->
          <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-industrial-blue/20"></div>

          <!-- Timeline Items -->
          <div class="space-y-16">
            <div
              v-for="(item, index) in timeline"
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
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic mb-6">
            Core <span class="text-industrial-blue">Values</span>
          </h2>
          <p class="text-slate-400 text-lg max-w-2xl mx-auto">
            The principles that guide everything we do
          </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div
            v-for="(value, index) in values"
            :key="index"
            class="glass-panel p-8 rounded-lg hover:bg-industrial-blue/10 transition-colors group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <component :is="value.icon" class="w-12 h-12 text-industrial-blue mb-6 group-hover:scale-110 transition-transform" />
            <h3 class="text-xl font-bold mb-4">{{ value.title }}</h3>
            <p class="text-slate-400 text-sm leading-relaxed">{{ value.description }}</p>
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
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Join Our <span class="text-yellow-400">Mission</span>
        </h2>
        <p class="text-xl mb-12 text-industrial-100">
          Be part of Bangladesh's engineering excellence story
        </p>
        <button class="bg-white text-industrial-blue px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
          Career Opportunities
        </button>
      </div>
    </section>
  </div>
</template>
