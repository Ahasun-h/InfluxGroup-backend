<template>
  <div class="product-gallery">
    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center h-64">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-500"></div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="text-center py-12">
      <p class="text-red-500 font-semibold">Error: {{ error }}</p>
      <button
        @click="fetchProducts()"
        class="mt-4 px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600"
      >
        Retry
      </button>
    </div>

    <!-- Products Grid -->
    <div v-else-if="products" class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div
        v-for="product in products"
        :key="product.id"
        class="product-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow"
      >
        <img
          :src="product.image || '/placeholder.jpg'"
          :alt="product.name"
          class="w-full h-48 object-cover"
        />
        <div class="p-6">
          <span class="text-xs font-semibold text-brand-600 uppercase tracking-wider">
            {{ product.category }}
          </span>
          <h3 class="text-xl font-bold text-gray-900 mt-2">{{ product.name }}</h3>
          <p class="text-gray-600 mt-2 line-clamp-2">{{ product.description }}</p>
          <router-link
            :to="`/products/${product.slug}`"
            class="inline-block mt-4 text-brand-600 font-semibold hover:text-brand-700"
          >
            View Details →
          </router-link>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12">
      <p class="text-gray-500">No products found.</p>
    </div>

    <!-- Pagination -->
    <div
      v-if="pagination && pagination.totalPages > 1"
      class="flex justify-center gap-2 mt-8"
    >
      <button
        v-for="page in pagination.totalPages"
        :key="page"
        @click="fetchProducts({ page, limit: 6 })"
        :class="[
          'px-4 py-2 rounded-lg',
          pagination.page === page
            ? 'bg-brand-500 text-white'
            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
        ]"
      >
        {{ page }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useProducts } from '@/composables/useApi'

const { products, loading, error, fetchProducts } = useProducts()

onMounted(() => {
  // Fetch products on component mount
  fetchProducts({ limit: 6 })
})
</script>

<style scoped>
.product-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
  transform: translateY(-4px);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>