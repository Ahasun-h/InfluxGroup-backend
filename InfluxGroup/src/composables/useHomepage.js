import { ref } from 'vue'
import { api } from '@/services/api'

/**
 * Vue 3 Composable for Homepage Content
 */
export function useHomepage() {
  const loading = ref(false)
  const error = ref(null)
  const homepage = ref(null)
  const company = ref(null)

  /**
   * Fetch homepage and company content from API
   */
  const fetchHomepageContent = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await api.get('/content/company-info')

      if (response.success) {
        homepage.value = response.data.homepage
        company.value = response.data.company
        return response.data
      }
    } catch (err) {
      error.value = err.message || 'Failed to fetch homepage content'
      console.error('Homepage API Error:', err)
      throw err
    } finally {
      loading.value = false
    }
  }

  return {
    homepage,
    company,
    loading,
    error,
    fetchHomepageContent,
  }
}