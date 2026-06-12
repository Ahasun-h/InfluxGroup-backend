<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import {
  Zap,
  Settings,
  Wind,
  Cpu,
  Filter,
  ArrowRight,
  SlidersHorizontal,
  Package
} from 'lucide-vue-next'
import { productService } from '../services/content'
import { API_CONFIG } from '../config/api'

const route = useRoute()

const products = ref([])
const categories = ref([])
const isLoading = ref(true)
const error = ref(null)

const categoryIcons = {
  transformers: Zap,
  switchgear: Settings,
  renewables: Wind,
  automation: Cpu,
  default: Package
}

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const currentCategory = computed(() => {
  return route.params.category || 'all'
})

const categoryTitle = computed(() => {
  if (currentCategory.value === 'all') {
    return 'All Products'
  }
  const category = categories.value.find(c => c.slug === currentCategory.value)
  return category ? category.name : 'Products'
})

const fetchCategories = async () => {
  try {
    const response = await productService.getCategories()
    categories.value = response || []
  } catch (err) {
    console.error('Failed to fetch categories:', err)
  }
}

const fetchProducts = async () => {
  try {
    isLoading.value = true
    const params = currentCategory.value !== 'all'
      ? { category: currentCategory.value, limit: 100 }
      : { limit: 100 }

    const response = await productService.getProducts(params)
    products.value = response.products || response.data || []
  } catch (err) {
    console.error('Failed to fetch products:', err)
    error.value = 'Failed to load products'
  } finally {
    isLoading.value = false
  }
}

// Watch for route changes to update products
watch(() => route.params.category, () => {
  fetchProducts()
}, { immediate: true })

onMounted(async () => {
  await Promise.all([fetchCategories(), fetchProducts()])
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
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">
              {{ currentCategory === 'all' ? 'Our Products' : categoryTitle }}
            </span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            {{ currentCategory === 'all' ? 'ENGINEERING' : '' }}
            <span class="text-industrial-blue">
              {{ currentCategory === 'all' ? 'EXCELLENCE' : categoryTitle }}
            </span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            {{
              currentCategory === 'all'
                ? 'Comprehensive portfolio of power systems and equipment designed for reliability, efficiency, and sustainability.'
                : `Explore our range of ${categoryTitle.toLowerCase()} designed for optimal performance and reliability.`
            }}
          </p>
        </div>
      </div>
    </section>

    <!-- Category Filter -->
    <section class="py-8 md:py-12 bg-white border-b top-[84px] lg:top-[92px] z-40 shadow-md">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap gap-3 md:gap-4 justify-center">
          <!-- All Products -->
          <router-link
            to="/products"
            class="flex items-center gap-2 px-4 md:px-6 py-2 md:py-3 rounded-sm font-bold uppercase text-[10px] md:text-xs tracking-wider transition-all"
            :class="currentCategory === 'all' ? 'bg-industrial-blue text-white' : 'bg-industrial-light text-industrial-dark hover:bg-industrial-blue/10'"
          >
            <Filter class="w-4 h-4" />
            <span class="hidden sm:inline">All Products</span>
            <span class="sm:hidden">All</span>
          </router-link>

          <!-- Category Links -->
          <router-link
            v-for="category in categories"
            :key="category.id || category.slug"
            :to="`/products/category/${category.slug}`"
            class="flex items-center gap-2 px-4 md:px-6 py-2 md:py-3 rounded-sm font-bold uppercase text-[10px] md:text-xs tracking-wider transition-all"
            :class="currentCategory === category.slug ? 'bg-industrial-blue text-white' : 'bg-industrial-light text-industrial-dark hover:bg-industrial-blue/10'"
          >
            <component
              :is="categoryIcons[category.slug] || categoryIcons.default"
              class="w-4 h-4"
            />
            <span class="hidden sm:inline">{{ category.name }}</span>
            <span class="sm:hidden">{{ category.name.substring(0, 3) }}</span>
          </router-link>
        </div>
      </div>
    </section>

    <!-- Products Grid -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-6">
        <!-- Loading State -->
        <div v-if="isLoading" class="flex flex-col items-center justify-center py-20 gap-4">
          <div class="w-12 h-12 border-4 border-industrial-blue border-t-transparent rounded-full animate-spin"></div>
          <p class="text-industrial-dark font-bold uppercase tracking-widest text-xs">Loading Products...</p>
        </div>

        <!-- Empty State -->
        <div v-else-if="products.length === 0" class="text-center py-20">
          <div class="flex flex-col items-center gap-4">
            <SlidersHorizontal class="w-16 h-16 text-slate-400" />
            <div>
              <p class="text-xl text-slate-500 font-medium mb-2">No products found</p>
              <p class="text-slate-400">Try selecting a different category</p>
            </div>
          </div>
        </div>

        <!-- Products Grid -->
        <div v-else class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="(product, index) in products"
            :key="product.id"
            class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <!-- Image -->
            <div class="relative h-64 overflow-hidden cursor-pointer" @click="$router.push(`/products/${product.slug}`)">
              <img
                :src="getImageUrl(product.image)"
                :alt="product.name"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/80 to-transparent"></div>
              <div class="absolute top-4 right-4 bg-industrial-blue text-white px-3 py-1 rounded-full text-xs font-bold uppercase">
                {{ product.category }}
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <h3
                class="text-xl font-display font-black uppercase italic mb-3 group-hover:text-industrial-blue transition-colors cursor-pointer"
                @click="$router.push(`/products/${product.slug}`)"
              >
                {{ product.name }}
              </h3>
              <p class="text-slate-600 text-sm mb-4 line-clamp-2">
                {{ product.description }}
              </p>

              <!-- Specifications -->
              <div v-if="product.specifications && product.specifications.length" class="mb-4">
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2">
                  Key Specifications
                </h4>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="(spec, idx) in product.specifications.slice(0, 3)"
                    :key="idx"
                    class="bg-industrial-light text-industrial-dark px-3 py-1 rounded text-xs font-medium"
                  >
                    {{ spec }}
                  </span>
                </div>
              </div>

              <!-- CTA -->
              <button
                @click="$router.push(`/products/${product.slug}`)"
                class="w-full bg-industrial-blue text-white py-3 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-red transition-colors flex items-center justify-center gap-2 group-hover:gap-4"
              >
                View Details <ArrowRight class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>

        <!-- Products Count -->
        <div v-if="!isLoading && products.length > 0" class="mt-8 text-center">
          <p class="text-slate-600 text-sm">
            Showing {{ products.length }} product{{ products.length !== 1 ? 's' : '' }}
            <span v-if="currentCategory !== 'all'">
              in {{ categoryTitle }}
            </span>
          </p>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Need Custom <span class="text-industrial-blue">Solutions?</span>
        </h2>
        <p class="text-xl mb-12 text-slate-300">
          Our engineering team can design and manufacture products to meet your specific requirements
        </p>
        <router-link
          to="/contact"
          class="inline-block bg-industrial-blue hover:bg-industrial-red text-white px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs transition-all shadow-2xl"
        >
          Contact Our Team
        </router-link>
      </div>
    </section>
  </div>
</template>