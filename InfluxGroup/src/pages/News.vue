<script setup>
import { ref, onMounted, computed } from 'vue'
import { Calendar, User, ArrowRight, Newspaper } from 'lucide-vue-next'
import contentService from '@/services/content'
import { API_CONFIG } from '@/config/api'

const newsItems = ref([])
const loading = ref(true)
const error = ref(null)

// Transform image URL to full path (following Projects.vue pattern)
const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

// Transform API data to match expected format
const transformNewsItem = (item) => ({
  id: item.id,
  title: item.title,
  slug: item.slug,
  excerpt: item.excerpt || '',
  date: formatDate(item.publication_date || item.published_at),
  author: item.author || 'Influx Group',
  category: item.category || 'News',
  image: getImageUrl(item.image),
  featured: item.featured || false,
  readTime: item.read_time ? `${item.read_time} min read` : '3 min read'
})

// Format date to readable format
const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

// Get featured news (first item)
const featuredNews = computed(() => {
  if (newsItems.value.length === 0) return null
  const featured = newsItems.value.find(item => item.featured) || newsItems.value[0]
  return featured
})

// Get regular news items (excluding featured)
const regularNews = computed(() => {
  if (newsItems.value.length === 0) return []
  const featuredId = featuredNews.value?.id
  return newsItems.value.filter(item => item.id !== featuredId)
})

// Fetch news data
const fetchNews = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await contentService.news.getNews({ limit: 10 })

    console.log('News API response:', response)

    // Handle different response structures
    let articles = []

    if (response && response.articles) {
      // From newsService: { articles: data, pagination }
      articles = response.articles
    } else if (Array.isArray(response)) {
      // Direct array response
      articles = response
    } else if (response && response.data) {
      // Handle Laravel paginator: { data: { data: [...] } }
      if (Array.isArray(response.data)) {
        articles = response.data
      } else if (response.data.data && Array.isArray(response.data.data)) {
        articles = response.data.data
      }
    }

    newsItems.value = articles.map(transformNewsItem)

    if (newsItems.value.length === 0) {
      console.warn('No news articles found')
    }
  } catch (err) {
    console.error('Error fetching news:', err)
    error.value = 'Failed to load news. Please try again later.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchNews()
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
        <!-- Loading State -->
        <div v-if="loading" class="text-center py-20">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-industrial-blue border-t-transparent"></div>
          <p class="mt-4 text-slate-600">Loading latest news...</p>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="text-center py-20">
          <p class="text-red-600">{{ error }}</p>
          <button @click="fetchNews" class="mt-4 text-industrial-blue hover:text-industrial-red font-semibold">
            Try Again
          </button>
        </div>

        <!-- News Content -->
        <template v-else>
          <!-- Featured Article -->
          <div
            v-if="featuredNews"
            class="rounded-lg overflow-hidden shadow-2xl mb-16 group cursor-pointer"
            v-motion-slide-visible-bottom
            @click="$router.push(`/news/${featuredNews.slug}`)"
          >
            <div class="grid md:grid-cols-2">
              <div class="relative h-96">
                <img
                  :src="featuredNews.image"
                  :alt="featuredNews.title"
                  class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                />
                <div class="absolute top-4 left-4 bg-industrial-blue text-white px-4 py-2 rounded-sm text-xs font-bold uppercase">
                  Featured
                </div>
              </div>
              <div class="p-12 flex flex-col justify-center">
                <div class="flex items-center gap-4 mb-4">
                  <span class="bg-industrial-light text-industrial-dark px-3 py-1 rounded text-xs font-bold uppercase">
                    {{ featuredNews.category }}
                  </span>
                  <div class="flex items-center gap-2 text-slate-500 text-sm">
                    <Calendar class="w-4 h-4" />
                    {{ featuredNews.date }}
                  </div>
                </div>
                <h2 class="text-3xl font-display text-industrial-dark uppercase italic mb-4 group-hover:text-industrial-blue transition-colors">
                  {{ featuredNews.title }}
                </h2>
                <p class="text-slate-600 mb-6 leading-relaxed">
                  {{ featuredNews.excerpt }}
                </p>
                <div class="flex items-center gap-4">
                  <div class="flex items-center gap-2 text-sm text-slate-500">
                    <User class="w-4 h-4" />
                    {{ featuredNews.author }}
                  </div>
                  <div class="text-sm text-slate-500">{{ featuredNews.readTime }}</div>
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
              v-for="(news, index) in regularNews"
              :key="news.id"
              class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group cursor-pointer"
              v-motion-slide-visible-bottom
              :delay="index * 100"
              @click="$router.push(`/news/${news.slug}`)"
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

                <h3 class="text-lg font-display text-industrial-dark uppercase italic mb-3 group-hover:text-industrial-blue transition-colors line-clamp-2">
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

          <!-- No News State -->
          <div v-if="newsItems.length === 0" class="text-center py-20">
            <Newspaper class="w-16 h-16 text-slate-300 mx-auto mb-4" />
            <p class="text-slate-600">No news articles available yet.</p>
          </div>
        </template>
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
