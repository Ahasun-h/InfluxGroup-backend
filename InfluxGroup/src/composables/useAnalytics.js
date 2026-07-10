// Analytics Composable for Vue Components
import { watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import analyticsTracking from '../services/analyticsTracking'

export function useAnalytics() {
  const route = useRoute()

  /**
   * Track current page view
   */
  const trackPageView = (customUrl = null, customTitle = null) => {
    const url = customUrl || route.path
    const title = customTitle || route.meta.title || document.title

    analyticsTracking.trackPageView(url, title)
  }

  /**
   * Auto-track route changes
   */
  const trackRoutes = () => {
    // Track initial page load
    onMounted(() => {
      trackPageView()
    })

    // Track route changes
    watch(
      () => route.path,
      (newPath, oldPath) => {
        if (newPath !== oldPath) {
          trackPageView()
        }
      }
    )
  }

  /**
   * Enable/disable analytics tracking
   */
  const setTrackingEnabled = (enabled) => {
    analyticsTracking.setTracking(enabled)
  }

  /**
   * Reset analytics session
   */
  const resetSession = () => {
    analyticsTracking.resetSession()
  }

  /**
   * Get session information
   */
  const getSessionInfo = () => {
    return analyticsTracking.getSessionInfo()
  }

  return {
    trackPageView,
    trackRoutes,
    setTrackingEnabled,
    resetSession,
    getSessionInfo,
  }
}