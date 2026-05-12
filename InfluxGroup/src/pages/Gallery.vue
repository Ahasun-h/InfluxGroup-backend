<script setup>
import { ref } from 'vue'
import { Play, Image as ImageIcon } from 'lucide-vue-next'

const activeTab = ref('photos')

const photos = [
  {
    id: 1,
    src: 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800',
    title: 'Matarbari Power Plant',
    category: 'Power Projects',
    description: '1200 MW Ultra-Super Critical Thermal Power Plant'
  },
  {
    id: 2,
    src: 'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?auto=format&fit=crop&q=80&w=800',
    title: 'Northern Solar Farm',
    category: 'Renewable Energy',
    description: '50 MW Utility-scale Solar Installation'
  },
  {
    id: 3,
    src: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=800',
    title: 'Transformer Manufacturing',
    category: 'Manufacturing',
    description: 'State-of-the-art Production Facility'
  },
  {
    id: 4,
    src: 'https://images.unsplash.com/photo-1518709766631-a6a7f45921c3?auto=format&fit=crop&q=80&w=800',
    title: 'Grid Substation',
    category: 'Transmission',
    description: '400 kV GIS Substation'
  },
  {
    id: 5,
    src: 'https://images.unsplash.com/photo-1532601224476-15c79f2f7a51?auto=format&fit=crop&q=80&w=800',
    title: 'Wind Power Project',
    category: 'Renewable Energy',
    description: '120 MW Wind Farm Installation'
  },
  {
    id: 6,
    src: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=800',
    title: 'Corporate HQ',
    category: 'Corporate',
    description: 'Headquarters Office in Dhaka'
  },
  {
    id: 7,
    src: 'https://images.unsplash.com/photo-1509391366360-fe5bb658589d?auto=format&fit=crop&q=80&w=800',
    title: 'Solar Panel Installation',
    category: 'Renewable Energy',
    description: 'Rooftop Solar Installation'
  },
  {
    id: 8,
    src: 'https://images.unsplash.com/photo-1544724569-5f546fa6629c?auto=format&fit=crop&q=80&w=800',
    title: 'Switchgear Assembly',
    category: 'Manufacturing',
    description: 'HV Switchgear Production Line'
  }
]

const videos = [
  {
    id: 1,
    thumbnail: 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800',
    title: 'Matarbari Power Plant Commissioning',
    duration: '5:32',
    category: 'Project Videos'
  },
  {
    id: 2,
    thumbnail: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=800',
    title: 'Manufacturing Facility Tour',
    duration: '8:15',
    category: 'Corporate Videos'
  },
  {
    id: 3,
    thumbnail: 'https://images.unsplash.com/photo-1509391366360-fe5bb658589d?auto=format&fit=crop&q=80&w=800',
    title: 'Solar Farm Installation Process',
    duration: '4:48',
    category: 'Technology'
  },
  {
    id: 4,
    thumbnail: 'https://images.unsplash.com/photo-1518709766631-a6a7f45921c3?auto=format&fit=crop&q=80&w=800',
    title: 'Grid Modernization Project',
    duration: '6:20',
    category: 'Project Videos'
  }
]

const categories = ['All', 'Power Projects', 'Renewable Energy', 'Manufacturing', 'Transmission', 'Corporate']
const selectedCategory = ref('All')
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
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">Media Gallery</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            VISUAL <span class="text-industrial-blue">STORY</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            Explore our projects, facilities, and achievements through our extensive photo and video gallery.
          </p>
        </div>
      </div>
    </section>

    <!-- Tabs -->
    <section class="bg-white border-b sticky top-20 z-30 shadow-md">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex gap-8">
          <button
            @click="activeTab = 'photos'"
            class="py-4 font-bold uppercase text-xs tracking-wider border-b-2 transition-colors"
            :class="activeTab === 'photos' ? 'border-industrial-blue text-industrial-blue' : 'border-transparent text-slate-500 hover:text-industrial-dark'"
          >
            <ImageIcon class="w-4 h-4 inline mr-2" />
            Photos
          </button>
          <button
            @click="activeTab = 'videos'"
            class="py-4 font-bold uppercase text-xs tracking-wider border-b-2 transition-colors"
            :class="activeTab === 'videos' ? 'border-industrial-blue text-industrial-blue' : 'border-transparent text-slate-500 hover:text-industrial-dark'"
          >
            <Play class="w-4 h-4 inline mr-2" />
            Videos
          </button>
        </div>
      </div>
    </section>

    <!-- Category Filter -->
    <section v-if="activeTab === 'photos'" class="py-8 bg-white border-b">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap gap-3">
          <button
            v-for="category in categories"
            :key="category"
            @click="selectedCategory = category"
            class="px-4 py-2 rounded-sm font-bold uppercase text-xs tracking-wider transition-all"
            :class="selectedCategory === category ? 'bg-industrial-blue text-white' : 'bg-industrial-light text-industrial-dark hover:bg-industrial-blue/10'"
          >
            {{ category }}
          </button>
        </div>
      </div>
    </section>

    <!-- Photos Grid -->
    <section v-if="activeTab === 'photos'" class="py-20">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <div
            v-for="(photo, index) in photos.filter(p => selectedCategory === 'All' || p.category === selectedCategory)"
            :key="photo.id"
            class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-all duration-500 aspect-square cursor-pointer"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <img
              :src="photo.src"
              :alt="photo.title"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div class="absolute bottom-0 left-0 right-0 p-6">
                <div class="text-industrial-blue text-xs font-black uppercase tracking-wider mb-2">
                  {{ photo.category }}
                </div>
                <h3 class="text-lg font-display font-black uppercase italic text-white mb-2">
                  {{ photo.title }}
                </h3>
                <p class="text-slate-300 text-sm line-clamp-2">
                  {{ photo.description }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Videos Grid -->
    <section v-if="activeTab === 'videos'" class="py-20">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="(video, index) in videos"
            :key="video.id"
            class="group relative overflow-hidden rounded-lg shadow-xl hover:shadow-2xl transition-all duration-500 cursor-pointer"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="relative aspect-video">
              <img
                :src="video.thumbnail"
                :alt="video.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
              />
              <div class="absolute inset-0 bg-black/40 group-hover:bg-black/60 transition-colors"></div>
              <div class="absolute top-4 left-4 bg-industrial-blue text-white px-3 py-1 rounded text-xs font-bold uppercase">
                {{ video.category }}
              </div>
              <div class="absolute bottom-4 right-4 bg-black/80 text-white px-3 py-1 rounded text-xs font-bold">
                {{ video.duration }}
              </div>
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-20 h-20 bg-industrial-blue/90 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                  <Play class="w-8 h-8 text-white ml-1" />
                </div>
              </div>
            </div>
            <div class="p-6 bg-white">
              <h3 class="text-lg font-display font-black uppercase italic mb-2 group-hover:text-industrial-blue transition-colors">
                {{ video.title }}
              </h3>
              <p class="text-slate-600 text-sm">{{ video.category }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats -->
    <section class="py-20 bg-industrial-dark text-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 text-center">
          <div v-motion-slide-visible-bottom>
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">500+</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Photos</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="100">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">50+</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Videos</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="200">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">25+</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Projects Documented</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="300">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">6</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Categories</div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
