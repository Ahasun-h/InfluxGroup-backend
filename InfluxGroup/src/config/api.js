// API Configuration
export const API_CONFIG = {
  baseURL: import.meta.env.VITE_API_URL || 'http://influx-group.test/api',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
}

// API Endpoints
export const API_ENDPOINTS = {
  // Products
  PRODUCTS: '/products',
  PRODUCT_CATEGORIES: '/products/categories',
  PRODUCT_BY_SLUG: (slug) => `/products/${slug}`,

  // Projects
  PROJECTS: '/projects',
  FEATURED_PROJECTS: '/projects/featured',
  PROJECT_BY_SLUG: (slug) => `/projects/${slug}`,

  // News
  NEWS: '/news',
  FEATURED_NEWS: '/news/featured',
  NEWS_CATEGORIES: '/news/categories',
  ARTICLE_BY_SLUG: (slug) => `/news/${slug}`,

  // Gallery
  GALLERY: '/gallery',
  GALLERY_CATEGORIES: '/gallery/categories',

  // Services
  SERVICES: '/services',
  SOLUTIONS: '/solutions',

  // Testimonials & Partners
  TESTIMONIALS: '/testimonials',
  PARTNERS: '/partners',

  // Careers
  JOBS: '/careers/jobs',

  // Pages
  PAGES: '/pages',
  PAGE_BY_SLUG: (slug) => `/pages/${slug}`,

  // Company Info
  COMPANY_INFO: '/content/company-info',

  // CMS Hero
  HERO: '/cms/hero',

  // CMS Brand Statements
  BRAND_STATEMENTS: '/cms/brand-statements',
}