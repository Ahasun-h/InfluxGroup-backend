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
    const { data, pagination } = await api.get(API_ENDPOINTS.PROJECTS, params)
    return { projects: data, pagination }
  },

  /**
   * Get featured projects
   */
  async getFeaturedProjects(params = {}) {
    const { data } = await api.get(API_ENDPOINTS.FEATURED_PROJECTS, params)
    return data
  },

  /**
   * Get project by slug
   */
  async getProjectBySlug(slug) {
    const { data } = await api.get(API_ENDPOINTS.PROJECT_BY_SLUG(slug))
    return data
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
    const { data } = await api.get(API_ENDPOINTS.SERVICES)
    return data
  },
}

export const solutionService = {
  /**
   * Get all solutions
   */
  async getSolutions() {
    const { data } = await api.get(API_ENDPOINTS.SOLUTIONS)
    return data
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
    const { data } = await api.get(API_ENDPOINTS.PAGES)
    return data
  },

  /**
   * Get page by slug
   */
  async getPageBySlug(slug) {
    const { data } = await api.get(API_ENDPOINTS.PAGE_BY_SLUG(slug))
    return data
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

// Export all services as a combined object
export const contentService = {
  products: productService,
  projects: projectService,
  news: newsService,
  gallery: galleryService,
  services: serviceService,
  solutions: solutionService,
  testimonials: testimonialService,
  partners: partnerService,
  careers: careerService,
  pages: pageService,
  company: companyService,
  hero: heroService,
  brand: brandService,
}

export default contentService