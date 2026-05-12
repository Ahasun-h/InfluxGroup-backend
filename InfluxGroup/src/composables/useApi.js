import { ref } from 'vue'
import { contentService } from '@/services/content'

/**
 * Vue 3 Composable for API calls with loading and error states
 */
export function useApi() {
  const loading = ref(false)
  const error = ref(null)
  const data = ref(null)

  /**
   * Execute API call with loading and error handling
   */
  const execute = async (apiFunction, ...args) => {
    loading.value = true
    error.value = null

    try {
      const result = await apiFunction(...args)
      data.value = result
      return result
    } catch (err) {
      error.value = err.message || 'An error occurred'
      console.error('API Error:', err)
      throw err
    } finally {
      loading.value = false
    }
  }

  /**
   * Reset state
   */
  const reset = () => {
    loading.value = false
    error.value = null
    data.value = null
  }

  return {
    data,
    loading,
    error,
    execute,
    reset,
    services: contentService,
  }
}

/**
 * Specific composables for each content type
 */
export function useProducts() {
  const { data, loading, error, execute } = useApi()

  const fetchProducts = (params = {}) => {
    return execute(contentService.products.getProducts, params)
  }

  const fetchProduct = (slug) => {
    return execute(contentService.products.getProductBySlug, slug)
  }

  const fetchCategories = () => {
    return execute(contentService.products.getCategories)
  }

  return {
    products: data,
    loading,
    error,
    fetchProducts,
    fetchProduct,
    fetchCategories,
  }
}

export function useProjects() {
  const { data, loading, error, execute } = useApi()

  const fetchProjects = (params = {}) => {
    return execute(contentService.projects.getProjects, params)
  }

  const fetchFeaturedProjects = (params = {}) => {
    return execute(contentService.projects.getFeaturedProjects, params)
  }

  const fetchProject = (slug) => {
    return execute(contentService.projects.getProjectBySlug, slug)
  }

  return {
    projects: data,
    loading,
    error,
    fetchProjects,
    fetchFeaturedProjects,
    fetchProject,
  }
}

export function useNews() {
  const { data, loading, error, execute } = useApi()

  const fetchNews = (params = {}) => {
    return execute(contentService.news.getNews, params)
  }

  const fetchFeaturedNews = (params = {}) => {
    return execute(contentService.news.getFeaturedNews, params)
  }

  const fetchArticle = (slug) => {
    return execute(contentService.news.getArticleBySlug, slug)
  }

  const fetchCategories = () => {
    return execute(contentService.news.getCategories)
  }

  return {
    articles: data,
    loading,
    error,
    fetchNews,
    fetchFeaturedNews,
    fetchArticle,
    fetchCategories,
  }
}

export function useServices() {
  const { data, loading, error, execute } = useApi()

  const fetchServices = () => {
    return execute(contentService.services.getServices)
  }

  return {
    services: data,
    loading,
    error,
    fetchServices,
  }
}

export function useGallery() {
  const { data, loading, error, execute } = useApi()

  const fetchGallery = (params = {}) => {
    return execute(contentService.gallery.getGallery, params)
  }

  const fetchCategories = () => {
    return execute(contentService.gallery.getCategories)
  }

  return {
    gallery: data,
    loading,
    error,
    fetchGallery,
    fetchCategories,
  }
}

export function useCareers() {
  const { data, loading, error, execute } = useApi()

  const fetchJobs = () => {
    return execute(contentService.careers.getJobs)
  }

  return {
    jobs: data,
    loading,
    error,
    fetchJobs,
  }
}

export function useCompany() {
  const { data, loading, error, execute } = useApi()

  const fetchCompanyInfo = () => {
    return execute(contentService.company.getCompanyInfo)
  }

  return {
    company: data,
    loading,
    error,
    fetchCompanyInfo,
  }
}