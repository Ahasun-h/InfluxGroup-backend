<script setup>
import { ref } from 'vue'
import { Calendar, User, ArrowRight, Newspaper } from 'lucide-vue-next'

const newsItems = [
  {
    id: 1,
    title: 'Influx Group Successfully Commissions 1200 MW Power Plant',
    excerpt: 'Major milestone achieved with successful commissioning of country\'s largest ultra-super critical thermal power plant at Matarbari.',
    date: 'January 15, 2026',
    author: 'Corporate Communications',
    category: 'Project Milestone',
    image: 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800',
    featured: true,
    readTime: '5 min read'
  },
  {
    id: 2,
    title: 'Strategic Partnership Signed with Global Technology Leader',
    excerpt: 'Influx Group enters into strategic partnership with leading European technology company for advanced grid automation solutions.',
    date: 'January 10, 2026',
    author: 'Business Development',
    category: 'Partnership',
    image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=800',
    featured: false,
    readTime: '3 min read'
  },
  {
    id: 3,
    title: 'Expanding Renewable Energy Portfolio with 50 MW Solar Project',
    excerpt: 'Company launches new solar energy division and announces first utility-scale solar project in northern region.',
    date: 'January 5, 2026',
    author: 'Renewable Energy Division',
    category: 'Renewable Energy',
    image: 'https://images.unsplash.com/photo-1509391366360-fe5bb658589d?auto=format&fit=crop&q=80&w=800',
    featured: false,
    readTime: '4 min read'
  },
  {
    id: 4,
    title: 'Influx Group Receives ISO 45001:2018 Certification',
    excerpt: 'Company achieves highest international standard for occupational health and safety management systems.',
    date: 'December 28, 2025',
    author: 'Quality Assurance',
    category: 'Certification',
    image: 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=800',
    featured: false,
    readTime: '3 min read'
  },
  {
    id: 5,
    title: 'Annual Technical Seminar 2025 Concludes Successfully',
    excerpt: 'Over 200 engineers from across Bangladesh participated in company\'s flagship technical knowledge sharing event.',
    date: 'December 20, 2025',
    author: 'Training & Development',
    category: 'Events',
    image: 'https://images.unsplash.com/photo-1544531586-fde5298cdd40?auto=format&fit=crop&q=80&w=800',
    featured: false,
    readTime: '4 min read'
  },
  {
    id: 6,
    title: 'New Manufacturing Facility Inaugurated',
    excerpt: 'State-of-the-art transformer manufacturing facility inaugurated, boosting production capacity by 200%.',
    date: 'December 15, 2025',
    author: 'Operations',
    category: 'Expansion',
    image: 'https://images.unsplash.com/photo-1565514020125-11d9590b5c7b?auto=format&fit=crop&q=80&w=800',
    featured: false,
    readTime: '5 min read'
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
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">News & Updates</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            LATEST <span class="text-industrial-blue">NEWS</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            Stay updated with the latest developments, achievements, and insights from Influx Group.
          </p>
        </div>
      </div>
    </section>

    <!-- Featured News -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div
          class="rounded-lg overflow-hidden shadow-2xl mb-16 group cursor-pointer"
          v-motion-slide-visible-bottom
        >
          <div class="grid md:grid-cols-2">
            <div class="relative h-96">
              <img
                :src="newsItems[0].image"
                :alt="newsItems[0].title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
              />
              <div class="absolute top-4 left-4 bg-industrial-blue text-white px-4 py-2 rounded-sm text-xs font-bold uppercase">
                Featured
              </div>
            </div>
            <div class="p-12 flex flex-col justify-center">
              <div class="flex items-center gap-4 mb-4">
                <span class="bg-industrial-light text-industrial-dark px-3 py-1 rounded text-xs font-bold uppercase">
                  {{ newsItems[0].category }}
                </span>
                <div class="flex items-center gap-2 text-slate-500 text-sm">
                  <Calendar class="w-4 h-4" />
                  {{ newsItems[0].date }}
                </div>
              </div>
              <h2 class="text-3xl font-display font-black uppercase italic mb-4 group-hover:text-industrial-blue transition-colors">
                {{ newsItems[0].title }}
              </h2>
              <p class="text-slate-600 mb-6 leading-relaxed">
                {{ newsItems[0].excerpt }}
              </p>
              <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-slate-500">
                  <User class="w-4 h-4" />
                  {{ newsItems[0].author }}
                </div>
                <div class="text-sm text-slate-500">{{ newsItems[0].readTime }}</div>
              </div>
              <button class="mt-6 text-industrial-blue font-bold uppercase text-xs tracking-wider flex items-center gap-2 group-hover:gap-4 transition-all">
                Read Full Story <ArrowRight class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>

        <!-- News Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="(news, index) in newsItems.slice(1)"
            :key="news.id"
            class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group cursor-pointer"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="relative h-48 overflow-hidden">
              <img
                :src="news.image"
                :alt="news.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
              />
              <div class="absolute top-4 left-4 bg-industrial-red text-white px-3 py-1 rounded text-xs font-bold uppercase">
                {{ news.category }}
              </div>
            </div>

            <div class="p-6">
              <div class="flex items-center gap-2 text-slate-500 text-xs mb-3">
                <Calendar class="w-3 h-3" />
                {{ news.date }}
              </div>

              <h3 class="text-lg font-display font-black uppercase italic mb-3 group-hover:text-industrial-blue transition-colors line-clamp-2">
                {{ news.title }}
              </h3>

              <p class="text-slate-600 text-sm mb-4 line-clamp-3">
                {{ news.excerpt }}
              </p>

              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs text-slate-500">
                  <User class="w-3 h-3" />
                  {{ news.author }}
                </div>
                <div class="text-xs text-slate-500">{{ news.readTime }}</div>
              </div>

              <button class="mt-4 text-industrial-blue font-bold uppercase text-xs tracking-wider flex items-center gap-2 group-hover:gap-4 transition-all">
                Read More <ArrowRight class="w-3 h-3" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <Newspaper class="w-16 h-16 text-industrial-blue mx-auto mb-8" />
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Subscribe to <span class="text-industrial-blue">Updates</span>
        </h2>
        <p class="text-xl mb-12 text-slate-300">
          Get the latest news and insights delivered to your inbox
        </p>
        <div class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
          <input
            type="email"
            placeholder="Enter your email"
            class="flex-1 px-6 py-4 rounded-sm bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:outline-none focus:border-industrial-blue"
          />
          <button class="bg-industrial-blue hover:bg-industrial-red text-white px-8 py-4 rounded-sm font-black uppercase tracking-widest text-xs transition-colors">
            Subscribe
          </button>
        </div>
      </div>
    </section>
  </div>
</template>
