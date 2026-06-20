<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { Calendar, User, Clock, Share2, ArrowLeft, ArrowRight } from 'lucide-vue-next'
import { newsService } from '../services/content'

const route = useRoute()
const article = ref(null)
const loading = ref(true)
const error = ref(null)
const currentImageIndex = ref(0)

const formattedDate = computed(() => {
  if (!article.value?.publication_date) return ''
  return new Date(article.value.publication_date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
})

const currentGalleryImage = computed(() => {
  if (!article.value?.gallery?.length) return null
  return article.value.gallery[currentImageIndex.value]
})

const nextImage = () => {
  if (article.value?.gallery && currentImageIndex.value < article.value.gallery.length - 1) {
    currentImageIndex.value++
  }
}

const prevImage = () => {
  if (currentImageIndex.value > 0) {
    currentImageIndex.value--
  }
}

const shareArticle = async () => {
  if (navigator.share) {
    try {
      await navigator.share({
        title: article.value?.title,
        text: article.value?.excerpt,
        url: window.location.href
      })
    } catch (err) {
      console.log('Share cancelled')
    }
  } else {
    // Fallback to clipboard
    navigator.clipboard.writeText(window.location.href)
    alert('Link copied to clipboard!')
  }
}

onMounted(async () => {
  try {
    const slug = route.params.slug
    const data = await newsService.getArticleBySlug(slug)
    article.value = data
  } catch (err) {
    error.value = 'Failed to load article'
    console.error('Error loading article:', err)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div v-if="loading" class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <div class="w-16 h-16 border-4 border-industrial-blue border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
      <p class="text-slate-600">Loading article...</p>
    </div>
  </div>

  <div v-else-if="error || !article" class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <h2 class="text-2xl font-bold text-slate-800 mb-4">Article Not Found</h2>
      <router-link to="/news" class="text-industrial-blue hover:underline">
        <ArrowLeft class="w-4 h-4 inline mr-1" />
        Back to News
      </router-link>
    </div>
  </div>

  <div v-else class="min-h-screen bg-industrial-light">
    <!-- Hero Section -->
    <section class="relative py-32 bg-industrial-dark text-white overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-industrial-blue/10 to-transparent"></div>
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <router-link to="/news" class="inline-flex items-center gap-2 text-industrial-blue hover:text-white transition-colors mb-8">
          <ArrowLeft class="w-4 h-4" />
          Back to News
        </router-link>

        <div v-motion-slide-visible-left>
          <div class="flex items-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">
              {{ article.category || 'News' }}
            </span>
          </div>

          <h1 class="text-4xl md:text-6xl font-display font-black uppercase italic leading-[0.9] mb-8">
            {{ article.title }}
          </h1>

          <div class="flex flex-wrap items-center gap-6 text-slate-300">
            <div v-if="article.author" class="flex items-center gap-2">
              <User class="w-5 h-5" />
              <span>{{ article.author }}</span>
              <span v-if="article.author_title" class="text-slate-400">({{ article.author_title }})</span>
            </div>
            <div v-if="formattedDate" class="flex items-center gap-2">
              <Calendar class="w-5 h-5" />
              <span>{{ formattedDate }}</span>
            </div>
            <div v-if="article.read_time" class="flex items-center gap-2">
              <Clock class="w-5 h-5" />
              <span>{{ article.read_time }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Image -->
    <section v-if="article.image" class="bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="relative -mt-20 mb-16">
          <img
            :src="article.image"
            :alt="article.title"
            class="w-full h-[500px] object-cover rounded-lg shadow-2xl"
          />
        </div>
      </div>
    </section>

    <!-- Article Content -->
    <section class="py-20 bg-white">
      <div class="max-w-4xl mx-auto px-6">
        <!-- Excerpt -->
        <div v-if="article.excerpt" class="mb-12" v-motion-slide-visible-bottom>
          <p class="text-2xl text-slate-600 font-medium leading-relaxed border-l-4 border-industrial-blue pl-6">
            {{ article.excerpt }}
          </p>
        </div>

        <!-- Content -->
        <div
          class="prose prose-lg max-w-none"
          v-motion-slide-visible-bottom
          v-html="article.content"
        ></div>

        <!-- Share -->
        <div class="mt-12 pt-12 border-t border-slate-200" v-motion-slide-visible-bottom>
          <button
            @click="shareArticle"
            class="flex items-center gap-2 text-industrial-blue hover:text-industrial-red transition-colors font-bold uppercase text-sm"
          >
            <Share2 class="w-5 h-5" />
            Share Article
          </button>
        </div>
      </div>
    </section>

    <!-- Gallery Section -->
    <section v-if="article.gallery && article.gallery.length > 0" class="py-20 bg-industrial-light">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-display font-black uppercase italic mb-4">
            Image <span class="text-industrial-blue">Gallery</span>
          </h2>
          <p class="text-slate-600">Visual highlights from the article</p>
        </div>

        <div class="relative">
          <!-- Main Image -->
          <div class="relative aspect-video bg-slate-900 rounded-lg overflow-hidden mb-4">
            <img
              v-if="currentGalleryImage"
              :src="currentGalleryImage"
              :alt="`${article.title} - Image ${currentImageIndex + 1}`"
              class="w-full h-full object-cover"
            />
          </div>

          <!-- Navigation -->
          <div class="flex justify-between items-center mb-4">
            <button
              @click="prevImage"
              :disabled="currentImageIndex === 0"
              class="flex items-center gap-2 bg-industrial-blue text-white px-6 py-3 rounded-sm font-bold uppercase text-sm hover:bg-industrial-red transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <ArrowLeft class="w-4 h-4" />
              Previous
            </button>
            <span class="text-slate-600 font-bold">
              {{ currentImageIndex + 1 }} / {{ article.gallery.length }}
            </span>
            <button
              @click="nextImage"
              :disabled="currentImageIndex === article.gallery.length - 1"
              class="flex items-center gap-2 bg-industrial-blue text-white px-6 py-3 rounded-sm font-bold uppercase text-sm hover:bg-industrial-red transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Next
              <ArrowRight class="w-4 h-4" />
            </button>
          </div>

          <!-- Thumbnails -->
          <div class="grid grid-cols-4 md:grid-cols-8 gap-2">
            <button
              v-for="(image, index) in article.gallery"
              :key="index"
              @click="currentImageIndex = index"
              class="aspect-video rounded overflow-hidden border-2 transition-all"
              :class="currentImageIndex === index ? 'border-industrial-blue' : 'border-transparent'"
            >
              <img
                :src="image"
                :alt="`${article.title} - Thumbnail ${index + 1}`"
                class="w-full h-full object-cover"
              />
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Stay <span class="text-industrial-blue">Updated</span>
        </h2>
        <p class="text-xl mb-12 text-slate-300">
          Get the latest news and insights from Influx Group
        </p>
        <router-link
          to="/contact"
          class="inline-flex items-center gap-3 bg-industrial-blue hover:bg-industrial-red text-white px-8 py-4 rounded-sm font-black uppercase tracking-widest text-sm transition-colors"
        >
          Contact Us
          <ArrowRight class="w-5 h-5" />
        </router-link>
      </div>
    </section>
  </div>
</template>

<style scoped>
.prose {
  color: #1e293b;
  line-height: 1.8;
}

.prose h2 {
  font-size: 2rem;
  font-weight: 700;
  margin-top: 2rem;
  margin-bottom: 1rem;
  color: #0f172a;
}

.prose h3 {
  font-size: 1.5rem;
  font-weight: 600;
  margin-top: 1.5rem;
  margin-bottom: 0.75rem;
  color: #0f172a;
}

.prose p {
  margin-bottom: 1.25rem;
}

.prose ul {
  list-style-type: disc;
  margin-left: 1.5rem;
  margin-bottom: 1.25rem;
}

.prose ol {
  list-style-type: decimal;
  margin-left: 1.5rem;
  margin-bottom: 1.25rem;
}

.prose li {
  margin-bottom: 0.5rem;
}

.prose a {
  color: #0066cc;
  text-decoration: underline;
}

.prose a:hover {
  color: #004499;
}

.prose strong {
  font-weight: 700;
  color: #0f172a;
}

.prose em {
  font-style: italic;
}

.prose blockquote {
  border-left: 4px solid #0066cc;
  padding-left: 1rem;
  margin: 1.5rem 0;
  font-style: italic;
  color: #64748b;
}

.prose code {
  background-color: #f1f5f9;
  padding: 0.2rem 0.4rem;
  border-radius: 0.25rem;
  font-family: monospace;
  font-size: 0.875em;
}

.prose pre {
  background-color: #1e293b;
  color: #f8fafc;
  padding: 1rem;
  border-radius: 0.5rem;
  overflow-x: auto;
  margin: 1.5rem 0;
}

.prose img {
  border-radius: 0.5rem;
  margin: 1.5rem 0;
  max-width: 100%;
  height: auto;
}
</style>
