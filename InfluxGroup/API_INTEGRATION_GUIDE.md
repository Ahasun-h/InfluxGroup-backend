# Laravel API Integration Guide for Vue.js Frontend

This guide explains how to integrate the Laravel backend API with your Vue.js frontend application.

## 📋 Overview

The Influx Group project uses a **Laravel backend** with a **Vue.js 3 frontend**. The backend provides RESTful APIs that the frontend consumes to display dynamic content.

## 🏗️ Architecture

```
┌─────────────────┐         ┌─────────────────┐
│   Vue.js 3      │         │   Laravel API   │
│   Frontend      │◄───────►│   Backend       │
│   (Port 5173)   │         │   (Port 80)     │
└─────────────────┘         └─────────────────┘
        │                           │
        │                           │
    Vite Dev Server            Laravel Routes
```

## 🚀 Setup Instructions

### 1. Backend Setup (Laravel)

1. **Configure CORS** (Already done in `config/cors.php`):
   ```php
   'allowed_origins' => ['http://localhost:5173'],
   'supports_credentials' => true,
   ```

2. **API Routes** (Already configured in `routes/api.php`):
   - Products: `/api/products`
   - Projects: `/api/projects`
   - News: `/api/news`
   - And more...

3. **Start Laravel Server**:
   ```bash
   cd G:\Herd\influx-group
   php artisan serve
   ```

### 2. Frontend Setup (Vue.js)

1. **Environment Configuration** (`.env`):
   ```env
   VITE_API_URL=http://influx-group.test/api
   VITE_APP_URL=http://localhost:5173
   ```

2. **Install Dependencies**:
   ```bash
   cd G:\Herd\influx-group\InfluxGroup
   npm install
   ```

3. **Start Vue Dev Server**:
   ```bash
   npm run dev
   ```

## 📁 Project Structure

```
InfluxGroup/src/
├── config/
│   └── api.js              # API configuration & endpoints
├── services/
│   ├── api.js              # HTTP client service
│   └── content.js          # Content API services
├── composables/
│   └── useApi.js           # Vue 3 composables
└── components/
    └── Examples/
        ├── ProductGallery.vue    # Example: Products list
        └── ProjectShowcase.vue   # Example: Projects grid
```

## 🔧 Usage Examples

### Using Composables (Recommended)

```vue
<script setup>
import { onMounted } from 'vue'
import { useProducts } from '@/composables/useApi'

const { products, loading, error, fetchProducts } = useProducts()

onMounted(() => {
  fetchProducts({ limit: 6 })
})
</script>

<template>
  <div v-if="loading">Loading...</div>
  <div v-else-if="error">Error: {{ error }}</div>
  <div v-else>
    <div v-for="product in products" :key="product.id">
      {{ product.name }}
    </div>
  </div>
</template>
```

### Using Services Directly

```javascript
import { contentService } from '@/services/content'

// Fetch products
const { products } = await contentService.products.getProducts({ limit: 10 })

// Fetch single product
const product = await contentService.products.getProductBySlug('product-slug')

// Fetch projects with filters
const { projects } = await contentService.projects.getProjects({
  category: 'energy',
  status: 'active'
})
```

### Using API Client Directly

```javascript
import { api } from '@/services/api'

// GET request
const response = await api.get('/products', { limit: 10 })

// POST request
const response = await api.post('/contact', {
  name: 'John Doe',
  email: 'john@example.com'
})
```

## 🌐 Available API Endpoints

### Products
- `GET /api/products` - Get all products
- `GET /api/products/categories` - Get product categories
- `GET /api/products/{slug}` - Get single product

### Projects
- `GET /api/projects` - Get all projects
- `GET /api/projects/featured` - Get featured projects
- `GET /api/projects/{slug}` - Get single project

### News
- `GET /api/news` - Get all news
- `GET /api/news/featured` - Get featured news
- `GET /api/news/categories` - Get news categories
- `GET /api/news/{slug}` - Get single article

### Gallery
- `GET /api/gallery` - Get gallery items
- `GET /api/gallery/categories` - Get gallery categories

### Services
- `GET /api/services` - Get all services
- `GET /api/solutions` - Get all solutions

### Testimonials & Partners
- `GET /api/testimonials` - Get all testimonials
- `GET /api/partners` - Get all partners

### Careers
- `GET /api/careers/jobs` - Get active job openings

### Pages
- `GET /api/pages` - Get all pages
- `GET /api/pages/{slug}` - Get page by slug

### Company Info
- `GET /api/content/company-info` - Get company information

## 📦 API Response Format

All API responses follow this consistent format:

```json
{
  "success": true,
  "data": [...],
  "pagination": {
    "total": 100,
    "page": 1,
    "limit": 10,
    "totalPages": 10
  }
}
```

## 🛡️ Error Handling

The API service includes automatic error handling:

```javascript
const { loading, error, data, execute } = useApi()

try {
  await execute(apiFunction, params)
} catch (err) {
  // Error is automatically caught and stored in `error.value`
  console.error('API Error:', error.value)
}
```

## 🔒 Authentication (Future)

For protected routes, you can add authentication:

```javascript
// In api.js
headers: {
  'Authorization': `Bearer ${token}`,
  'Content-Type': 'application/json',
}
```

## 🧪 Testing API Endpoints

You can test the API using:

1. **Browser**: Navigate to `http://influx-group.test/api/products`
2. **Postman**: Import the collection at `Influx_Group_API_Collection.postman_collection.json`
3. **cURL**:
   ```bash
   curl http://influx-group.test/api/products
   ```

## 🐛 Troubleshooting

### CORS Errors
- Ensure Laravel CORS config allows your Vue origin
- Check that `config/cors.php` has correct settings

### Network Errors
- Verify Laravel server is running
- Check API URL in `.env` file
- Ensure no firewall blocking the connection

### 404 Errors
- Confirm API routes are defined in `routes/api.php`
- Check that the endpoint URL is correct

## 📚 Additional Resources

- [Laravel API Documentation](https://laravel.com/docs/api)
- [Vue 3 Composition API](https://vuejs.org/guide/introduction.html)
- [Vite Dev Server](https://vitejs.dev/)

## 🎯 Next Steps

1. Create Vue components for each section
2. Implement routing with Vue Router
3. Add loading states and error handling
4. Optimize performance with pagination
5. Add caching for better performance

---

**Need Help?** Check the component examples in `src/components/Examples/` for working implementations!