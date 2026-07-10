// Analytics Tracking Service for Vue Frontend
import { API_CONFIG } from '../config/api'

class AnalyticsTrackingService {
  constructor() {
    this.sessionId = this.getSessionId()
    this.trackingEnabled = true
    this.queue = []
    this.isBatching = false
  }

  /**
   * Get or create session ID
   */
  getSessionId() {
    let sessionId = localStorage.getItem('analytics_session_id')

    if (!sessionId) {
      sessionId = this.generateSessionId()
      localStorage.setItem('analytics_session_id', sessionId)
    }

    return sessionId
  }

  /**
   * Generate unique session ID
   */
  generateSessionId() {
    return 'vue_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9)
  }

  /**
   * Track page view
   */
  trackPageView(url, title = null) {
    if (!this.trackingEnabled) return

    const pageData = {
      session_id: this.sessionId,
      url: url || window.location.pathname,
      title: title || document.title,
      referer: document.referrer || null,
      user_agent: navigator.userAgent,
    }

    // Add to queue for batch processing
    this.queue.push(pageData)

    // Process queue immediately or batch
    if (!this.isBatching) {
      this.processQueue()
    }
  }

  /**
   * Process queued tracking requests
   */
  async processQueue() {
    if (this.queue.length === 0) return

    this.isBatching = true
    const pageView = this.queue.shift()

    try {
      const response = await fetch(`${API_CONFIG.baseURL}/analytics/track`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify(pageView),
      })

      if (response.ok) {
        const data = await response.json()
        console.log('Analytics tracked:', data)

        // Process remaining queue
        if (this.queue.length > 0) {
          setTimeout(() => this.processQueue(), 100)
        } else {
          this.isBatching = false
        }
      } else {
        console.error('Analytics tracking failed:', response.status)
        // Re-queue failed request
        this.queue.unshift(pageView)
        this.isBatching = false
      }
    } catch (error) {
      console.error('Analytics tracking error:', error)
      // Re-queue failed request
      this.queue.unshift(pageView)
      this.isBatching = false
    }
  }

  /**
   * Enable/disable tracking
   */
  setTracking(enabled) {
    this.trackingEnabled = enabled
  }

  /**
   * Reset session ID
   */
  resetSession() {
    localStorage.removeItem('analytics_session_id')
    this.sessionId = this.generateSessionId()
    localStorage.setItem('analytics_session_id', this.sessionId)
  }

  /**
   * Get current session info
   */
  getSessionInfo() {
    return {
      session_id: this.sessionId,
      queue_length: this.queue.length,
      is_tracking: this.trackingEnabled,
    }
  }
}

// Create singleton instance
const analyticsTracking = new AnalyticsTrackingService()

export default analyticsTracking