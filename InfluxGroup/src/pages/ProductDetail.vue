<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  Zap,
  Settings,
  Package,
  Shield,
  CheckCircle,
  ArrowLeft,
  Download,
  Share2,
  Mail,
  Phone
} from 'lucide-vue-next'
import { productService } from '../services/content'
import { API_CONFIG } from '../config/api'

const route = useRoute()
const router = useRouter()

const product = ref(null)
const isLoading = ref(true)
const error = ref(null)
const activeTab = ref('overview')

const tabs = [
  { id: 'overview', name: 'Overview' },
  { id: 'specifications', name: 'Specifications' },
  { id: 'features', name: 'Features' },
  { id: 'applications', name: 'Applications' }
]

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const fetchProduct = async () => {
  try {
    isLoading.value = true
    const slug = route.params.slug
    const response = await productService.getProductBySlug(slug)
    product.value = response
  } catch (err) {
    console.error('Failed to fetch product:', err)
    error.value = 'Failed to load product details'
  } finally {
    isLoading.value = false
  }
}

const shareProduct = async () => {
  if (navigator.share) {
    try {
      await navigator.share({
        title: product.value?.name,
        text: product.value?.description,
        url: window.location.href
      })
    } catch (err) {
      console.log('Share canceled')
    }
  }
}

const downloadSpecSheet = () => {
  // Implement spec sheet download logic
  console.log('Downloading spec sheet for:', product.value?.name)
}

const goBack = () => {
  router.push('/products')
}

onMounted(fetchProduct)
</script>

<template>
  <div class="min-h-screen bg-industrial-light">
    <!-- Loading State -->
    <div v-if="isLoading" class="flex items-center justify-center min-h-screen">
      <div class="flex flex-col items-center gap-4">
        <div class="w-16 h-16 border-4 border-industrial-blue border-t-transparent rounded-full animate-spin"></div>
        <p class="text-industrial-dark font-bold uppercase tracking-widest text-xs">Loading Product...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <p class="text-xl text-red-600 font-bold mb-4">{{ error }}</p>
        <button
          @click="goBack"
          class="bg-industrial-blue text-white px-6 py-3 rounded-sm font-bold uppercase text-xs tracking-wider hover:bg-industrial-red transition-colors"
        >
          Back to Products
        </button>
      </div>
    </div>

    <!-- Product Detail -->
    <div v-else-if="product">
      <!-- Header Section -->
      <section class="bg-industrial-dark text-white">
        <div class="max-w-7xl mx-auto px-6 py-8">
          <button
            @click="goBack"
            class="flex items-center gap-2 text-industrial-blue hover:text-white transition-colors mb-6"
          >
            <ArrowLeft class="w-5 h-5" />
            <span class="font-bold uppercase text-xs tracking-wider">Back to Products</span>
          </button>

          <div class="grid lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div class="relative">
              <div class="aspect-video rounded-lg overflow-hidden">
                <img
                  :src="getImageUrl(product.image)"
                  :alt="product.name"
                  class="w-full h-full object-cover"
                />
              </div>

              <!-- Action Buttons -->
              <div class="flex gap-3 mt-4">
                <button
                  @click="shareProduct"
                  class="flex-1 bg-industrial-blue/20 hover:bg-industrial-blue/40 text-white px-4 py-3 rounded-sm font-bold uppercase text-xs tracking-wider transition-colors flex items-center justify-center gap-2"
                >
                  <Share2 class="w-4 h-4" />
                  Share
                </button>
                <button
                  @click="downloadSpecSheet"
                  class="flex-1 bg-industrial-blue/20 hover:bg-industrial-blue/40 text-white px-4 py-3 rounded-sm font-bold uppercase text-xs tracking-wider transition-colors flex items-center justify-center gap-2"
                >
                  <Download class="w-4 h-4" />
                  Spec Sheet
                </button>
              </div>
            </div>

            <!-- Product Info -->
            <div>
              <div class="flex items-center gap-3 mb-4">
                <div class="h-px w-12 bg-industrial-blue"></div>
                <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">
                  {{ product.category || 'Product' }}
                </span>
              </div>

              <h1 class="text-4xl md:text-5xl font-display font-black uppercase italic leading-[0.9] mb-6">
                {{ product.name }}
              </h1>

              <p class="text-xl text-slate-300 mb-8 leading-relaxed">
                {{ product.description }}
              </p>

              <!-- Quick Specs -->
              <div v-if="product.specifications && product.specifications.length" class="grid grid-cols-2 gap-4 mb-8">
                <div
                  v-for="(spec, index) in product.specifications.slice(0, 4)"
                  :key="index"
                  class="bg-industrial-blue/10 rounded-lg p-4"
                >
                  <div class="text-industrial-blue text-xs font-black uppercase tracking-wider mb-1">
                    {{ spec.label || 'Specification' }}
                  </div>
                  <div class="text-white font-bold text-sm">
                    {{ spec.value || spec }}
                  </div>
                </div>
              </div>

              <!-- CTA Buttons -->
              <div class="flex flex-col sm:flex-row gap-4">
                <a
                  href="mailto:info@influxgroup.com"
                  class="flex-1 bg-industrial-blue hover:bg-industrial-red text-white px-8 py-4 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3"
                >
                  <Mail class="w-5 h-5" />
                  Request Quote
                </a>
                <a
                  href="tel:+88029876543"
                  class="flex-1 bg-white text-industrial-dark hover:bg-industrial-light px-8 py-4 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3"
                >
                  <Phone class="w-5 h-5" />
                  Contact Us
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Content Tabs -->
      <section class="bg-white border-b sticky top-20 z-30 shadow-md">
        <div class="max-w-7xl mx-auto px-6">
          <div class="flex gap-8">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              class="py-4 px-2 font-bold uppercase text-xs tracking-wider transition-colors relative"
              :class="activeTab === tab.id ? 'text-industrial-blue' : 'text-slate-500 hover:text-industrial-dark'"
            >
              {{ tab.name }}
              <div
                v-if="activeTab === tab.id"
                class="absolute bottom-0 left-0 right-0 h-1 bg-industrial-blue"
              ></div>
            </button>
          </div>
        </div>
      </section>

      <!-- Tab Content -->
      <section class="py-16">
        <div class="max-w-7xl mx-auto px-6">

          <!-- Overview Tab -->
          <div v-if="activeTab === 'overview'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Product <span class="text-industrial-blue">Overview</span>
            </h2>

            <div class="prose prose-lg max-w-none">
              <div v-if="product.overview" class="text-slate-700 leading-relaxed space-y-4">
                <p>{{ product.overview }}</p>
              </div>

              <div v-else class="text-slate-700 leading-relaxed space-y-4">
                <p>{{ product.description }}</p>
                <p>
                  This product is designed and manufactured to meet international standards
                  and customer requirements. With our commitment to quality and innovation,
                  we deliver reliable solutions for power systems and infrastructure.
                </p>
              </div>
            </div>

            <!-- Key Features -->
            <div v-if="product.features && product.features.length" class="mt-12">
              <h3 class="text-xl font-bold mb-6">Key Features</h3>
              <div class="grid md:grid-cols-2 gap-4">
                <div
                  v-for="(feature, index) in product.features"
                  :key="index"
                  class="flex items-start gap-3 bg-industrial-light p-4 rounded-lg"
                >
                  <CheckCircle class="w-5 h-5 text-industrial-blue flex-shrink-0 mt-0.5" />
                  <span class="text-slate-700">{{ feature }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Specifications Tab -->
          <div v-if="activeTab === 'specifications'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Technical <span class="text-industrial-blue">Specifications</span>
            </h2>

            <div v-if="product.specifications && product.specifications.length" class="space-y-4">
              <div
                v-for="(spec, index) in product.specifications"
                :key="index"
                class="flex justify-between items-center py-4 border-b border-slate-200"
              >
                <span class="font-bold text-industrial-dark">
                  {{ spec.label || `Specification ${index + 1}` }}
                </span>
                <span class="text-slate-600">{{ spec.value || spec }}</span>
              </div>
            </div>

            <div v-else class="text-slate-500">
              <p>Detailed specifications will be provided upon request.</p>
            </div>
          </div>

          <!-- Features Tab -->
          <div v-if="activeTab === 'features'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Product <span class="text-industrial-blue">Features</span>
            </h2>

            <div v-if="product.features && product.features.length" class="grid md:grid-cols-2 gap-6">
              <div
                v-for="(feature, index) in product.features"
                :key="index"
                class="bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow"
              >
                <div class="flex items-start gap-4">
                  <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                    <CheckCircle class="w-6 h-6 text-white" />
                  </div>
                  <div>
                    <h4 class="font-bold text-industrial-dark mb-2">{{ feature }}</h4>
                    <p class="text-slate-600 text-sm">
                      Designed to enhance performance and reliability in various operating conditions.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="text-slate-500">
              <p>Features information will be provided upon request.</p>
            </div>
          </div>

          <!-- Applications Tab -->
          <div v-if="activeTab === 'applications'" class="max-w-4xl">
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Typical <span class="text-industrial-blue">Applications</span>
            </h2>

            <div v-if="product.applications && product.applications.length" class="grid md:grid-cols-2 gap-6">
              <div
                v-for="(application, index) in product.applications"
                :key="index"
                class="bg-gradient-to-br from-industrial-blue to-industrial-dark text-white rounded-lg p-6"
              >
                <div class="flex items-start gap-4">
                  <Settings class="w-8 h-8 flex-shrink-0" />
                  <div>
                    <h4 class="font-bold text-lg mb-2">{{ application }}</h4>
                    <p class="text-industrial-100 text-sm">
                      Optimized for reliable performance in demanding environments.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="text-slate-500">
              <p>Application information will be provided upon request.</p>
            </div>
          </div>

        </div>
      </section>

      <!-- Related Products -->
      <section v-if="product.related_products && product.related_products.length" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
          <h2 class="text-3xl font-display font-black uppercase italic mb-12">
            Related <span class="text-industrial-blue">Products</span>
          </h2>

          <div class="grid md:grid-cols-3 gap-8">
            <div
              v-for="related in product.related_products"
              :key="related.id"
              class="bg-industrial-light rounded-lg overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
              @click="router.push(`/products/${related.slug}`)"
            >
              <div class="aspect-video">
                <img
                  :src="getImageUrl(related.image)"
                  :alt="related.name"
                  class="w-full h-full object-cover"
                />
              </div>
              <div class="p-4">
                <h3 class="font-bold text-industrial-dark mb-2">{{ related.name }}</h3>
                <p class="text-slate-600 text-sm line-clamp-2">{{ related.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="py-32 bg-industrial-blue text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
            Need More <span class="text-yellow-400">Information?</span>
          </h2>
          <p class="text-xl mb-12 text-industrial-100">
            Our engineering team is ready to provide detailed specifications and technical support
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a
              href="mailto:info@influxgroup.com"
              class="bg-white text-industrial-blue px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl"
            >
              Contact Our Team
            </a>
            <a
              href="tel:+88029876543"
              class="bg-industrial-dark text-white px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-white hover:text-industrial-dark transition-all shadow-2xl"
            >
              Call Us
            </a>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>