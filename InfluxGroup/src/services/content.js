import { api } from './api'
import { API_ENDPOINTS } from '../config/api'

/**
 * Product Service
 */
export const productService = {
  /**
   * Get all products with optional filtering
   */
  async getProducts(params = {}) {
    const { data, pagination } = await api.get(API_ENDPOINTS.PRODUCTS, params)
    return { products: data, pagination }
  },

  /**
   * Get featured products for homepage
   */
  async getFeaturedProducts() {
    try {
      console.log('productService: Fetching featured products from', API_ENDPOINTS.FEATURED_PRODUCTS)
      const response = await api.get(API_ENDPOINTS.FEATURED_PRODUCTS)
      console.log('productService: Featured products response received', response)
      return response.data || []
    } catch (error) {
      console.error('productService: Error fetching featured products', error)
      throw error
    }
  },

  /**
   * Get product categories for homepage filters
   */
  async getProductCategoriesList() {
    try {
      console.log('productService: Fetching product categories from', API_ENDPOINTS.PRODUCT_CATEGORIES_LIST)
      const response = await api.get(API_ENDPOINTS.PRODUCT_CATEGORIES_LIST)
      console.log('productService: Product categories response received', response)
      return response.data || []
    } catch (error) {
      console.error('productService: Error fetching product categories', error)
      throw error
    }
  },

  /**
   * Get product by slug
   */
  async getProductBySlug(slug) {
    const { data } = await api.get(API_ENDPOINTS.PRODUCT_BY_SLUG(slug))
    return data
  },

  /**
   * Get product categories
   */
  async getCategories() {
    const { data } = await api.get(API_ENDPOINTS.PRODUCT_CATEGORIES)
    return data
  },
}

/**
 * Project Service
 */
export const projectService = {
  /**
   * Get all projects with optional filtering
   */
  async getProjects(params = {}) {
    const response = await api.get(API_ENDPOINTS.PROJECTS, params)
    return response.data || []
  },

  /**
   * Get featured projects
   */
  async getFeaturedProjects(params = {}) {
    const response = await api.get(API_ENDPOINTS.FEATURED_PROJECTS, params)
    return response.data || []
  },

  /**
   * Get project by slug
   */
  async getProjectBySlug(slug) {
    const response = await api.get(API_ENDPOINTS.PROJECT_BY_SLUG(slug))
    return response.data || null
  },

  /**
   * Get project categories
   */
  async getProjectCategories(params = {}) {
    const response = await api.get(API_ENDPOINTS.PROJECT_CATEGORIES, params)
    return response.data || []
  },
}

/**
 * News Service
 */
export const newsService = {
  /**
   * Get all news articles with optional filtering
   */
  async getNews(params = {}) {
    const { data, pagination } = await api.get(API_ENDPOINTS.NEWS, params)
    return { articles: data, pagination }
  },

  /**
   * Get featured news
   */
  async getFeaturedNews(params = {}) {
    const { data } = await api.get(API_ENDPOINTS.FEATURED_NEWS, params)
    return data
  },

  /**
   * Get article by slug
   */
  async getArticleBySlug(slug) {
    const { data } = await api.get(API_ENDPOINTS.ARTICLE_BY_SLUG(slug))
    return data
  },

  /**
   * Get news categories
   */
  async getCategories() {
    const { data } = await api.get(API_ENDPOINTS.NEWS_CATEGORIES)
    return data
  },
}

/**
 * Gallery Service
 */
export const galleryService = {
  /**
   * Get all gallery items
   */
  async getGallery(params = {}) {
    const { data } = await api.get(API_ENDPOINTS.GALLERY, params)
    return data
  },

  /**
   * Get gallery categories
   */
  async getCategories() {
    const { data } = await api.get(API_ENDPOINTS.GALLERY_CATEGORIES)
    return data
  },
}

/**
 * Service & Solution Services
 */
export const serviceService = {
  /**
   * Get all services
   */
  async getServices() {
    const response = await api.get(API_ENDPOINTS.SERVICES)
    return response.data || []
  },

  /**
   * Get latest services for homepage
   */
  async getLatestServices() {
    try {
      console.log('serviceService: Fetching latest services from', API_ENDPOINTS.LATEST_SERVICES)
      const response = await api.get(API_ENDPOINTS.LATEST_SERVICES)
      console.log('serviceService: Latest services response received', response)
      return response.data || []
    } catch (error) {
      console.error('serviceService: Error fetching latest services', error)
      throw error
    }
  },

  /**
   * Get service by slug
   */
  async getServiceBySlug(slug) {
    const response = await api.get(API_ENDPOINTS.SERVICE_BY_SLUG(slug))
    return response.data || null
  },
}

export const solutionService = {
  /**
   * Get all solutions
   */
  async getSolutions() {
    const response = await api.get(API_ENDPOINTS.SOLUTIONS)
    return response.data || []
  },

  /**
   * Get latest solutions for homepage
   */
  async getLatestSolutions() {
    try {
      console.log('solutionService: Fetching latest solutions from', API_ENDPOINTS.LATEST_SOLUTIONS)
      const response = await api.get(API_ENDPOINTS.LATEST_SOLUTIONS)
      console.log('solutionService: Latest solutions response received', response)
      return response.data || []
    } catch (error) {
      console.error('solutionService: Error fetching latest solutions', error)
      throw error
    }
  },

  /**
   * Get solution by slug
   */
  async getSolutionBySlug(slug) {
    const response = await api.get(API_ENDPOINTS.SOLUTION_BY_SLUG(slug))
    return response.data || null
  },
}

/**
 * Testimonial Service
 */
export const testimonialService = {
  /**
   * Get all testimonials
   */
  async getTestimonials() {
    const { data } = await api.get(API_ENDPOINTS.TESTIMONIALS)
    return data
  },
}

/**
 * Partner Service
 */
export const partnerService = {
  /**
   * Get all partners
   */
  async getPartners() {
    const { data } = await api.get(API_ENDPOINTS.PARTNERS)
    return data
  },
}

/**
 * Service Categories Service
 */
export const serviceCategoriesService = {
  /**
   * Get service categories for industries section
   */
  async getServiceCategories() {
    try {
      console.log('serviceCategoriesService: Fetching from', API_ENDPOINTS.SERVICE_CATEGORIES)
      const response = await api.get(API_ENDPOINTS.SERVICE_CATEGORIES)
      console.log('serviceCategoriesService: Response received', response)
      return response
    } catch (error) {
      console.error('serviceCategoriesService: Error fetching service categories', error)
      throw error
    }
  },
}

/**
 * Career Service
 */
export const careerService = {
  /**
   * Get all active job openings
   */
  async getJobs() {
    const { data } = await api.get(API_ENDPOINTS.JOBS)
    return data
  },
}

/**
 * Page Service
 */
export const pageService = {
  /**
   * Get all pages
   */
  async getPages() {
    try {
      console.log('pageService: Fetching pages from', API_ENDPOINTS.PAGES)
      const response = await api.get(API_ENDPOINTS.PAGES)
      console.log('pageService: Pages response received', response)
      return response || []
    } catch (error) {
      console.error('pageService: Error fetching pages', error)
      throw error
    }
  },

  /**
   * Get page by slug
   */
  async getPageBySlug(slug) {
    try {
      console.log('pageService: Fetching page by slug', slug)
      const response = await api.get(API_ENDPOINTS.PAGE_BY_SLUG(slug))
      console.log('pageService: Page response received', response)
      return response || null
    } catch (error) {
      console.error('pageService: Error fetching page by slug', error)
      throw error
    }
  },
}

/**
 * Company Service
 */
export const companyService = {
  /**
   * Get company information
   */
  async getCompanyInfo() {
    const { data } = await api.get(API_ENDPOINTS.COMPANY_INFO)
    return data
  },
}

/**
 * Hero Service
 */
export const heroService = {
  /**
   * Get hero section data
   */
  async getHeroData() {
    try {
      console.log('heroService: Fetching from', API_ENDPOINTS.HERO)
      const response = await api.get(API_ENDPOINTS.HERO)
      console.log('heroService: Response received', response)
      return response
    } catch (error) {
      console.error('heroService: Error fetching hero data', error)
      throw error
    }
  },
}

/**
 * Brand Statements Service
 */
export const brandService = {
  /**
   * Get brand statements data
   */
  async getBrandStatements() {
    try {
      console.log('brandService: Fetching from', API_ENDPOINTS.BRAND_STATEMENTS)
      const response = await api.get(API_ENDPOINTS.BRAND_STATEMENTS)
      console.log('brandService: Response received', response)
      return response
    } catch (error) {
      console.error('brandService: Error fetching brand statements', error)
      throw error
    }
  },
}

/**
 * Mission Vision Service
 */
export const missionVisionService = {
  /**
   * Get mission & vision data
   */
  async getMissionVisionData() {
    try {
      console.log('missionVisionService: Fetching from', API_ENDPOINTS.MISSION_VISION)
      const response = await api.get(API_ENDPOINTS.MISSION_VISION)
      console.log('missionVisionService: Response received', response)
      return response
    } catch (error) {
      console.error('missionVisionService: Error fetching mission vision data', error)
      throw error
    }
  },
}

/**
 * Journey Timeline Service
 */
export const journeyService = {
  /**
   * Get journey timeline data
   */
  async getJourneyData() {
    try {
      console.log('journeyService: Fetching from', API_ENDPOINTS.JOURNEY)
      const response = await api.get(API_ENDPOINTS.JOURNEY)
      console.log('journeyService: Response received', response)
      return response
    } catch (error) {
      console.error('journeyService: Error fetching journey data', error)
      throw error
    }
  },
}

/**
 * Core Values Service
 */
export const coreValuesService = {
  /**
   * Get core values data
   */
  async getCoreValuesData() {
    try {
      console.log('coreValuesService: Fetching from', API_ENDPOINTS.CORE_VALUES)
      const response = await api.get(API_ENDPOINTS.CORE_VALUES)
      console.log('coreValuesService: Response received', response)
      return response
    } catch (error) {
      console.error('coreValuesService: Error fetching core values data', error)
      throw error
    }
  },
}

/**
 * Contact CTA Service
 */
export const contactCtaService = {
  /**
   * Get contact CTA data
   */
  async getContactCtaData() {
    try {
      console.log('contactCtaService: Fetching from', API_ENDPOINTS.CONTACT_CTA)
      const response = await api.get(API_ENDPOINTS.CONTACT_CTA)
      console.log('contactCtaService: Response received', response)
      return response
    } catch (error) {
      console.error('contactCtaService: Error fetching contact CTA data', error)
      throw error
    }
  },
}

/**
 * Career CTA Service
 */
export const careerCtaService = {
  /**
   * Get career CTA data
   */
  async getCareerCtaData() {
    try {
      console.log('careerCtaService: Fetching from', API_ENDPOINTS.CAREER_CTA)
      const response = await api.get(API_ENDPOINTS.CAREER_CTA)
      console.log('careerCtaService: Response received', response)
      return response
    } catch (error) {
      console.error('careerCtaService: Error fetching career CTA data', error)
      throw error
    }
  },
}

/**
 * Footer Service
 */
export const footerService = {
  /**
   * Get footer section data
   */
  async getFooterData() {
    try {
      console.log('footerService: Fetching from', API_ENDPOINTS.FOOTER)
      const response = await api.get(API_ENDPOINTS.FOOTER)
      console.log('footerService: Footer response received', response)
      return response
    } catch (error) {
      console.error('footerService: Error fetching footer data', error)
      throw error
    }
  },
}

/**
 * Contact Section Service
 */
export const contactSectionService = {
  /**
   * Get contact section data
   */
  async getContactSectionData() {
    try {
      console.log('contactSectionService: Fetching from', API_ENDPOINTS.CONTACT_SECTION)
      const response = await api.get(API_ENDPOINTS.CONTACT_SECTION)
      console.log('contactSectionService: Response received', response)
      return response
    } catch (error) {
      console.error('contactSectionService: Error fetching contact section data', error)
      throw error
    }
  },
}

// Export all services as a combined object
const contentService = {
  products: productService,
  projects: projectService,
  news: newsService,
  gallery: galleryService,
  services: serviceService,
  solutions: solutionService,
  testimonials: testimonialService,
  partners: partnerService,
  serviceCategories: serviceCategoriesService,
  careers: careerService,
  pages: pageService,
  company: companyService,
  hero: heroService,
  brand: brandService,
  missionVision: missionVisionService,
  journey: journeyService,
  coreValues: coreValuesService,
  contactCta: contactCtaService,
  careerCta: careerCtaService,
  contactSection: contactSectionService,
  footer: footerService,
}

// Export the combined contentService as default export
// Note: All individual services are already exported above with 'export const'
export default contentService