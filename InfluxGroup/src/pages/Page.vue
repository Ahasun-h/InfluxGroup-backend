<template>
  <div class="min-h-screen bg-industrial-dark">
    <!-- Hero Section -->
    <section class="relative py-32 bg-gradient-to-br from-industrial-dark to-industrial-blue">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center">
          <h1 class="text-5xl md:text-6xl font-display font-black uppercase italic text-white mb-6">
            {{ page?.title || 'Loading...' }}
          </h1>
          <div class="flex items-center justify-center gap-2 text-industrial-blue">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-sm font-bold uppercase tracking-wider text-industrial-blue">
              {{ page?.title || '' }}
            </span>
            <div class="h-px w-12 bg-industrial-blue"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Content Section -->
    <section class="py-20 bg-white">
      <div class="max-w-4xl mx-auto px-6">
        <div
          v-if="page?.content"
          class="page-content prose prose-lg max-w-none"
          v-html="page.content"
        ></div>
        <div v-else-if="loading" class="text-center py-20">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-industrial-blue"></div>
          <p class="text-slate-600 mt-4">Loading page content...</p>
        </div>
        <div v-else class="text-center py-20">
          <p class="text-slate-600">Page not found or loading failed.</p>
          <a href="/" class="inline-block mt-6 text-industrial-blue hover:underline">Return to Home</a>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { pageService } from '../services/content'

const route = useRoute()
const page = ref(null)
const loading = ref(true)

const fetchPage = async () => {
  try {
    loading.value = true
    const slug = route.params.slug
    console.log('Fetching page with slug:', slug)

    const response = await pageService.getPageBySlug(slug)
    console.log('Page response:', response)

    if (response && response.success && response.data) {
      page.value = response.data
      // Update page title
      document.title = `${page.value.title} | Influx Group`
      console.log('Page loaded successfully:', page.value)
    } else {
      console.error('Invalid response or page not found')
      page.value = null
    }
  } catch (error) {
    console.error('Failed to fetch page:', error)
    page.value = null
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchPage()
})
</script>

<style scoped>
.page-content {
  min-height: 400px;
}

.page-content :deep(h1),
.page-content :deep(h2),
.page-content :deep(h3),
.page-content :deep(h4),
.page-content :deep(h5),
.page-content :deep(h6) {
  color: #1e293b;
  font-weight: 700;
  margin-top: 1.5em;
  margin-bottom: 0.5em;
}

.page-content :deep(h1) {
  font-size: 2.25rem;
  line-height: 2.5rem;
}

.page-content :deep(h2) {
  font-size: 1.875rem;
  line-height: 2.25rem;
}

.page-content :deep(h3) {
  font-size: 1.5rem;
  line-height: 2rem;
}

.page-content :deep(p) {
  margin-bottom: 1em;
  line-height: 1.75;
  color: #475569;
}

.page-content :deep(ul),
.page-content :deep(ol) {
  margin-left: 1.5em;
  margin-bottom: 1em;
}

.page-content :deep(li) {
  margin-bottom: 0.5em;
  color: #475569;
}

.page-content :deep(a) {
  color: #0284c7;
  text-decoration: underline;
}

.page-content :deep(a:hover) {
  color: #0369a1;
}

.page-content :deep(strong) {
  font-weight: 700;
  color: #1e293b;
}

.page-content :deep(code) {
  background-color: #f1f5f9;
  color: #0f172a;
  padding: 0.2em 0.4em;
  border-radius: 0.25rem;
  font-size: 0.875em;
}

.page-content :deep(pre) {
  background-color: #1e293b;
  color: #f8fafc;
  padding: 1em;
  border-radius: 0.5rem;
  overflow-x: auto;
  margin-bottom: 1em;
}

.page-content :deep(blockquote) {
  border-left: 4px solid #0284c7;
  padding-left: 1em;
  margin-left: 0;
  color: #475569;
  font-style: italic;
}

.page-content :deep(table) {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1em;
}

.page-content :deep(th),
.page-content :deep(td) {
  border: 1px solid #e2e8f0;
  padding: 0.5em 1em;
  text-align: left;
}

.page-content :deep(th) {
  background-color: #f8fafc;
  font-weight: 700;
}
</style>
