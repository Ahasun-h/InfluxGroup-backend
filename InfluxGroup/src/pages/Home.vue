<script setup>
import { ref, computed, onMounted } from 'vue'
import { projectService, companyService, heroService, brandService, missionVisionService, journeyService, coreValuesService, contactCtaService, testimonialService, partnerService, serviceCategoriesService, productService } from '../services/content'
import { API_CONFIG } from '../config/api'
import {
  Zap,
  Settings,
  ShieldCheck,
  Activity,
  ChevronRight,
  Phone,
  Mail,
  MapPin,
  ArrowUpRight,
  Plus,
  ArrowRight,
  Monitor,
  Cpu,
  Wind,
  Award,
  Users,
  Target,
  CheckCircle,
  Building2,
  Factory,
  Wrench,
  Cog,
  Star,
  TrendingUp,
  Briefcase,
  X
} from 'lucide-vue-next'

const selectedProject = ref(null)
const projectFilter = ref('all')
const activeProductCategory = ref('all')
const brandStatements = ref(null)

const productCategories = computed(() => {
  if (heroData.value?.categories && heroData.value.categories.length > 0) {
    return heroData.value.categories.map(cat => {
      // Check if icon contains SVG HTML
      if (cat.icon && cat.icon.includes('<svg')) {
        return {
          name: cat.name,
          icon: cat.icon, // Store SVG HTML directly
          isSvg: true, // Flag to indicate this is SVG HTML
          count: cat.count
        }
      }
      // Otherwise, map icon name to component
      return {
        name: cat.name,
        icon: iconMap[cat.icon] || Zap,
        isSvg: false,
        count: cat.count
      }
    })
  }

  // Default categories
  return [
    { name: 'Transformers', icon: Zap, isSvg: false, count: '45+' },
    { name: 'Switchgear', icon: Settings, isSvg: false, count: '120+' },
    { name: 'Renewables', icon: Wind, isSvg: false, count: '12GW' },
    { name: 'Automation', icon: Cpu, isSvg: false, count: '80+' }
  ]
})

const products = [
  {
    title: 'High-Voltage Transformer',
    model: 'EP-450 Series',
    desc: 'Core power distribution technology for industrial grids.',
    image: 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800',
    color: 'industrial-blue'
  },
  {
    title: 'Intelligent Switchgear',
    model: 'JRC-G3 Switch',
    desc: 'Automated circuit protection and load management.',
    image: 'https://images.unsplash.com/photo-1544724569-5f546fa6629c?auto=format&fit=crop&q=80&w=800',
    color: 'industrial-red'
  },
  {
    title: 'Solar Inverters',
    model: 'REX-Solar V2',
    desc: 'High-conversion efficiency for utility-scale solar farms.',
    image: 'https://images.unsplash.com/photo-1509391366360-fe5bb658589d?auto=format&fit=crop&q=80&w=800',
    color: 'industrial-blue'
  },
  {
    title: 'Grid Control Unit',
    model: 'TRX-Monitor',
    desc: 'Real-time grid synchronization and performance tracking.',
    image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800',
    color: 'industrial-red'
  }
]

const homepageData = ref(null)
const heroData = ref(null)
const missionVisionData = ref(null)
const journeyData = ref(null)
const coreValuesData = ref(null)
const contactCtaData = ref(null)
const testimonialsData = ref(null)
const partnersData = ref(null)
const serviceCategoriesData = ref(null)
const featuredProductsData = ref(null)
const productCategoriesData = ref(null)
const projectCategoriesData = ref(null)

// Icon mapping for backwards compatibility
const iconMap = {
  ShieldCheck,
  Award,
  Users,
  TrendingUp,
  Zap,
  Target,
  Activity,
  Settings
}

const stats = computed(() => {
  // Use brandStatements stats if available
  if (brandStatements.value?.stats && brandStatements.value.stats.length > 0) {
    return brandStatements.value.stats.map(stat => ({
      value: stat.value || stat.number || '0',
      label: stat.label || stat.title || 'N/A'
    }))
  }

  // Fallback to homepageData stats
  if (!homepageData.value?.stats) {
    return [
      { value: '45+', label: 'Years Experience' },
      { value: '15GW', label: 'Power Generated' },
      { value: '250+', label: 'Global Clients' },
      { value: '500+', label: 'Technical Staff' }
    ]
  }
  const s = homepageData.value.stats
  return [
    { value: s.years_experience + '+', label: 'Years Experience' },
    { value: s.projects_completed + '+', label: 'Projects Completed' },
    { value: s.happy_clients + '+', label: 'Happy Clients' },
    { value: s.awards_won + '+', label: 'Awards Won' }
  ]
})

const featuredProjects = ref([])

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1466611653911-95282fc3656b?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  return `${API_CONFIG.baseURL.replace('/api', '')}${path}`
}

const isEmoji = (str) => {
  if (!str) return false
  // Simple emoji detection - check if the string is short and contains emoji-like characters
  const hasEmoji = /[\u2600-\u26FF\u2700-\u27BF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDEFF]/.test(str)
  return str.length <= 10 && hasEmoji
}

const fetchFeaturedProjects = async () => {
  try {
    const data = await projectService.getFeaturedProjects()
    featuredProjects.value = data
  } catch (error) {
    console.error('Failed to fetch featured projects:', error)
  }
}

const fetchHomepageData = async () => {
  try {
    const data = await companyService.getCompanyInfo()
    if (data && data.homepage) {
      homepageData.value = data.homepage
    }
  } catch (error) {
    console.error('Failed to fetch homepage data:', error)
  }
}

const fetchHeroData = async () => {
  try {
    console.log('Fetching hero data from /api/cms/hero...')
    const response = await heroService.getHeroData()
    console.log('Hero data response:', response)

    // Check if response has data property
    if (response && response.data) {
      heroData.value = response.data
      console.log('Hero section data loaded successfully:', heroData.value)
    } else if (response) {
      heroData.value = response
      console.log('Hero section data loaded (direct):', heroData.value)
    } else {
      console.warn('Hero data response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch hero data:', error)
    console.error('Error message:', error.message)
    console.error('Error stack:', error.stack)

    // Set default hero data as fallback
    heroData.value = {
      badge: 'Leaders in Energy',
      title: 'POWERING BANGLADESH',
      description: 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.',
      primary_cta: {
        text: 'EXPLORE CATALOG',
        link: '/projects'
      },
      secondary_cta: {
        text: 'CORPORATE PROFILE',
        link: '/about'
      },
      background_image: '/hero.png',
      categories: []
    }
  }
}

const fetchBrandStatements = async () => {
  try {
    console.log('Fetching brand statements from /api/cms/brand-statements...')
    const response = await brandService.getBrandStatements()
    console.log('Brand statements response:', response)

    if (response && response.data) {
      brandStatements.value = response.data
      console.log('Brand statements loaded successfully:', brandStatements.value)
    }
  } catch (error) {
    console.error('Failed to fetch brand statements:', error)

    // Set default brand statements as fallback
    brandStatements.value = {
      title: 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING',
      description: 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
      image: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
      overlay_title: 'Core Reliability',
      overlay_text: 'Zero Downtime Operation Protocols',
      stats: [
        { value: '45+', label: 'Years Experience' },
        { value: '15GW', label: 'Power Generated' },
        { value: '250+', label: 'Global Clients' },
        { value: '500+', label: 'Technical Staff' }
      ]
    }
  }
}

const fetchMissionVisionData = async () => {
  try {
    console.log('Fetching mission & vision data from /api/cms/mission-vision...')
    const response = await missionVisionService.getMissionVisionData()
    console.log('Mission & Vision response:', response)

    // Check if response has data property
    if (response && response.data) {
      missionVisionData.value = response.data
      console.log('Mission & Vision data loaded successfully:', missionVisionData.value)
    } else if (response) {
      missionVisionData.value = response
      console.log('Mission & Vision data loaded (direct):', missionVisionData.value)
    } else {
      console.warn('Mission & Vision data response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch mission & vision data:', error)
    console.error('Error message:', error.message)

    // Set default mission & vision data as fallback
    missionVisionData.value = {
      mission: {
        title: 'Our Mission',
        description: 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
        points: [
          'Powering Bangladesh\'s development through innovative energy solutions',
          'Ensuring energy security for future generations',
          'Building sustainable infrastructure nationwide'
        ]
      },
      vision: {
        title: 'Our Vision',
        description: 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
        points: [
          'Regional leadership in sustainable infrastructure development',
          'Global recognition for engineering excellence',
          'Pioneering renewable energy adoption'
        ]
      }
    }
  }
}

const fetchJourneyData = async () => {
  try {
    console.log('Fetching journey timeline data from /api/cms/journey...')
    const response = await journeyService.getJourneyData()
    console.log('Journey timeline response:', response)

    // Check if response has data property
    if (response && response.data) {
      journeyData.value = response.data
      console.log('Journey timeline data loaded successfully:', journeyData.value)
    } else if (response) {
      journeyData.value = response
      console.log('Journey timeline data loaded (direct):', journeyData.value)
    } else {
      console.warn('Journey timeline data response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch journey timeline data:', error)
    console.error('Error message:', error.message)

    // Set default journey timeline data as fallback
    journeyData.value = {
      title: 'Our Journey',
      subtitle: 'Building Tomorrow\'s Infrastructure Today',
      milestones: [
        { year: '1980', title: 'Foundation', description: 'Influx Group established as a small electrical contractor' },
        { year: '1995', title: 'Expansion', description: 'Entered power transmission and distribution sector' },
        { year: '2005', title: 'Manufacturing', description: 'Started manufacturing transformers and switchgear' },
        { year: '2015', title: 'Renewables', description: 'Diversified into solar and wind energy solutions' },
        { year: '2026', title: 'Regional Hub', description: 'Expanded operations across South Asia' }
      ]
    }
  }
}

const fetchCoreValuesData = async () => {
  try {
    console.log('Fetching core values data from /api/cms/core-values...')
    const response = await coreValuesService.getCoreValuesData()
    console.log('Core values response:', response)

    // Check if response has data property
    if (response && response.data) {
      coreValuesData.value = response.data
      console.log('Core values data loaded successfully:', coreValuesData.value)
    } else if (response) {
      coreValuesData.value = response
      console.log('Core values data loaded (direct):', coreValuesData.value)
    } else {
      console.warn('Core values data response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch core values data:', error)
    console.error('Error message:', error.message)

    // Set default core values data as fallback
    coreValuesData.value = {
      title: 'Core Values',
      subtitle: 'The principles that guide everything we do',
      values: [
        { icon: 'ShieldCheck', title: 'Safety First', description: 'Zero-compromise approach to workplace and operational safety' },
        { icon: 'Award', title: 'Quality Excellence', description: 'ISO 9001:2015 certified processes and international standards' },
        { icon: 'Users', title: 'Customer Focus', description: 'Dedicated to delivering beyond client expectations' },
        { icon: 'TrendingUp', title: 'Innovation Driven', description: 'Continuous investment in R&D and cutting-edge technology' }
      ]
    }
  }
}

const fetchContactCtaData = async () => {
  try {
    console.log('Fetching contact CTA data from /api/cms/contact-cta...')
    const response = await contactCtaService.getContactCtaData()
    console.log('Contact CTA response:', response)

    // Check if response has data property
    if (response && response.data) {
      contactCtaData.value = response.data
      console.log('Contact CTA data loaded successfully:', contactCtaData.value)
    } else if (response) {
      contactCtaData.value = response
      console.log('Contact CTA data loaded (direct):', contactCtaData.value)
    } else {
      console.warn('Contact CTA data response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch contact CTA data:', error)
    console.error('Error message:', error.message)

    // Set default contact CTA data as fallback
    contactCtaData.value = {
      title: 'Ready to Power Your Success?',
      description: "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs. Our team is ready to provide expert consultation and tailored solutions.",
      button_text: 'Get in Touch',
      button_link: '/contact'
    }
  }
}

const fetchTestimonials = async () => {
  try {
    console.log('Fetching testimonials from /api/cms/testimonials...')
    const response = await testimonialService.getTestimonials()
    console.log('Testimonials response:', response)

    if (response && response.data) {
      testimonialsData.value = response.data
      console.log('Testimonials loaded successfully:', testimonialsData.value)
    } else if (response) {
      testimonialsData.value = response
      console.log('Testimonials loaded (direct):', testimonialsData.value)
    } else {
      console.warn('Testimonials response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch testimonials:', error)

    // Set default testimonials as fallback
    testimonialsData.value = {
      subtitle: 'Testimonials',
      title: 'What Our Clients Say',
      description: 'Trusted by leading organizations across Bangladesh and beyond',
      testimonials: []
    }
  }
}

const fetchPartners = async () => {
  try {
    console.log('Fetching partners from /api/cms/partners...')
    const response = await partnerService.getPartners()
    console.log('Partners response:', response)

    if (response && response.data) {
      partnersData.value = response.data
      console.log('Partners data loaded successfully:', partnersData.value)
    } else if (response) {
      partnersData.value = response
      console.log('Partners data loaded (direct):', partnersData.value)
    } else {
      console.warn('Partners data response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch partners data:', error)
    console.error('Error message:', error.message)

    // Set default partners data as fallback
    partnersData.value = {
      title: 'Trusted by Industry Leaders',
      subtitle: 'Proud partner to government agencies, multinational corporations, and leading enterprises',
      list: [
        { name: 'BPDB', logo: '🏭' },
        { name: 'ADB', logo: '🏦' },
        { name: 'World Bank', logo: '🌐' },
        { name: 'BERC', logo: '⚡' },
        { name: 'IEC', logo: '🔌' },
        { name: 'IEEE', logo: '📡' }
      ]
    }
  }
}

const fetchServiceCategories = async () => {
  try {
    console.log('Fetching service categories from /api/cms/service-categories...')
    const response = await serviceCategoriesService.getServiceCategories()
    console.log('Service categories response:', response)

    if (response && response.data) {
      serviceCategoriesData.value = response.data
      console.log('Service categories loaded successfully:', serviceCategoriesData.value)
    } else if (response) {
      serviceCategoriesData.value = response
      console.log('Service categories loaded (direct):', serviceCategoriesData.value)
    } else {
      console.warn('Service categories response is empty or invalid')
    }
  } catch (error) {
    console.error('Failed to fetch service categories:', error)

    // Set default service categories as fallback
    serviceCategoriesData.value = []
  }
}

const fetchFeaturedProductsData = async () => {
  try {
    console.log('Fetching featured products from /api/products/featured...')
    const products = await productService.getFeaturedProducts()
    console.log('Featured products response:', products)

    if (products && products.length > 0) {
      featuredProductsData.value = products
      console.log('Featured products loaded successfully:', featuredProductsData.value)
    } else {
      console.warn('No featured products found')
      featuredProductsData.value = []
    }
  } catch (error) {
    console.error('Failed to fetch featured products:', error)
    featuredProductsData.value = []
  }
}

const fetchProductCategories = async () => {
  try {
    console.log('Fetching product categories from /api/products/categories-list...')
    const categories = await productService.getProductCategoriesList()
    console.log('Product categories response:', categories)

    if (categories && categories.length > 0) {
      productCategoriesData.value = categories
      console.log('Product categories loaded successfully:', productCategoriesData.value)
    } else {
      console.warn('No product categories found')
      productCategoriesData.value = []
    }
  } catch (error) {
    console.error('Failed to fetch product categories:', error)
    productCategoriesData.value = []
  }
}

const fetchProjectCategories = async () => {
  try {
    console.log('Fetching project categories from /api/projects/categories...')
    const categories = await projectService.getProjectCategories()
    console.log('Project categories response:', categories)

    if (categories && categories.length > 0) {
      projectCategoriesData.value = categories
      console.log('Project categories loaded successfully:', projectCategoriesData.value)
    } else {
      console.warn('No project categories found')
      projectCategoriesData.value = []
    }
  } catch (error) {
    console.error('Failed to fetch project categories:', error)
    projectCategoriesData.value = []
  }
}

onMounted(() => {
  fetchFeaturedProjects()
  fetchHomepageData()
  fetchHeroData()
  fetchBrandStatements()
  fetchMissionVisionData()
  fetchJourneyData()
  fetchCoreValuesData()
  fetchContactCtaData()
  fetchTestimonials()
  fetchPartners()
  fetchServiceCategories()
  fetchProductCategories()
  fetchProjectCategories()
  fetchFeaturedProductsData()
})

const filteredProjects = computed(() => {
  if (projectFilter.value === 'all') return featuredProjects.value

  return featuredProjects.value.filter(p => {
    // Handle different category field structures
    if (p.category?.slug === projectFilter.value) return true
    if (typeof p.category === 'string' && p.category === projectFilter.value) return true
    if (p.category_id === projectFilter.value) return true
    if (p.type === projectFilter.value) return true

    // Also check if category_id matches any category in our list
    if (p.category_id && projectCategoriesData.value) {
      const category = projectCategoriesData.value.find(c => c.id === p.category_id)
      if (category && category.slug === projectFilter.value) return true
    }

    return false
  })
})

const projectCategoryList = computed(() => {
  // Start with "All Projects" as the first category
  const categories = [
    { id: 'all', name: 'All Projects', slug: 'all' }
  ]

  // Add dynamic categories from API if available
  if (projectCategoriesData.value && projectCategoriesData.value.length > 0) {
    console.log('Using project categories from API:', projectCategoriesData.value)
    projectCategoriesData.value.forEach(category => {
      categories.push({
        id: category.id,
        name: category.name,
        slug: category.slug
      })
    })
  } else {
    // Fallback to hardcoded categories if no API data
    console.log('Using fallback project categories')
    categories.push(
      { id: 'infrastructure', name: 'Infrastructure', slug: 'infrastructure' },
      { id: 'renewable', name: 'Renewable', slug: 'renewable' }
    )
  }

  return categories
})

const openProjectModal = (project) => {
  selectedProject.value = project
  document.body.style.overflow = 'hidden'
}

const closeProjectModal = () => {
  selectedProject.value = null
  document.body.style.overflow = 'auto'
}

const setProjectFilter = (filter) => {
  projectFilter.value = filter
}

// Helper function to format brand title with highlighted word
const formatBrandTitle = (title) => {
  if (!title) return ''

  // Get the highlighted word from homepage data or use default
  const highlightedWord = homepageData.value?.brand_statement?.highlighted_word || 'AUTHORITY'

  // Split the title and wrap the highlighted word with span
  const parts = title.split(highlightedWord)
  return parts.join(`<span class="text-industrial-blue">${highlightedWord}</span>`)
}

// Mission & Vision from About page - now using dynamic data from dedicated API
const missionVision = computed(() => {
  // Use dedicated API data if available
  if (missionVisionData.value) {
    const mv = missionVisionData.value
    console.log('Using dedicated mission-vision API data:', mv)

    return [
      {
        icon: Zap,
        title: mv.mission?.title || 'Our Mission',
        description: mv.mission?.description || 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
        points: mv.mission?.points || [
          'Powering Bangladesh\'s development through innovative energy solutions',
          'Ensuring energy security for future generations',
          'Building sustainable infrastructure nationwide'
        ]
      },
      {
        icon: Target,
        title: mv.vision?.title || 'Our Vision',
        description: mv.vision?.description || 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
        points: mv.vision?.points || [
          'Regional leadership in sustainable infrastructure development',
          'Global recognition for engineering excellence',
          'Pioneering renewable energy adoption'
        ]
      }
    ]
  }

  // Fallback to homepageData for backwards compatibility
  if (homepageData.value?.mission_vision) {
    const mv = homepageData.value.mission_vision
    console.log('Using homepageData mission_vision as fallback:', mv)

    return [
      {
        icon: Zap,
        title: mv.mission?.title || 'Our Mission',
        description: mv.mission?.description || 'To deliver reliable, efficient, and sustainable power solutions...',
        points: mv.mission?.points || []
      },
      {
        icon: Target,
        title: mv.vision?.title || 'Our Vision',
        description: mv.vision?.description || 'To be the leading engineering conglomerate...',
        points: mv.vision?.points || []
      }
    ]
  }

  // Default values if no data
  console.log('Using default mission & vision values')
  return [
    {
      icon: Zap,
      title: 'Our Mission',
      description: 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
      points: [
        'Powering Bangladesh\'s development through innovative energy solutions',
        'Ensuring energy security for future generations',
        'Building sustainable infrastructure nationwide'
      ]
    },
    {
      icon: Target,
      title: 'Our Vision',
      description: 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
      points: [
        'Regional leadership in sustainable infrastructure development',
        'Global recognition for engineering excellence',
        'Pioneering renewable energy adoption'
      ]
    }
  ]
})

// Timeline from About page - now using dynamic data from dedicated API
const timeline = computed(() => {
  // Use dedicated API data if available
  if (journeyData.value?.milestones) {
    console.log('Using journey API data:', journeyData.value)
    return journeyData.value.milestones
  }

  // Fallback to homepageData for backwards compatibility
  if (homepageData.value?.journey?.milestones) {
    console.log('Using homepageData journey as fallback:', homepageData.value.journey)
    return homepageData.value.journey.milestones
  }

  // Default values if no data
  console.log('Using default journey timeline values')
  return [
    { year: '1980', title: 'Foundation', description: 'Influx Group established as a small electrical contractor' },
    { year: '1995', title: 'Expansion', description: 'Entered power transmission and distribution sector' },
    { year: '2005', title: 'Manufacturing', description: 'Started manufacturing transformers and switchgear' },
    { year: '2015', title: 'Renewables', description: 'Diversified into solar and wind energy solutions' },
    { year: '2026', title: 'Regional Hub', description: 'Expanded operations across South Asia' }
  ]
})

// Core Values from admin panel - now using SVG data
const coreValues = computed(() => {
  // Use dedicated API data if available
  if (coreValuesData.value?.values) {
    console.log('Using core values API data:', coreValuesData.value)
    const cv = coreValuesData.value
    return {
      title: cv.title || 'Core Values',
      subtitle: cv.subtitle || 'The principles that guide everything we do',
      list: cv.values.map(v => ({
        title: v.title || '',
        description: v.description || '',
        // If icon contains SVG, use it as component, otherwise map icon names
        icon: v.icon?.includes('<svg') ? {
          template: v.icon
        } : (iconMap[v.icon] || ShieldCheck)
      }))
    }
  }

  // Fallback to homepageData for backwards compatibility
  if (homepageData.value?.core_values) {
    console.log('Using homepageData core values as fallback:', homepageData.value.core_values)
    const cv = homepageData.value.core_values
    return {
      title: cv.title || 'Core Values',
      subtitle: cv.subtitle || 'The principles that guide everything we do',
      list: cv.list.map(v => ({
        title: v.title || '',
        description: v.description || '',
        // If icon contains SVG, use it as component, otherwise map icon names
        icon: v.icon?.includes('<svg') ? {
          template: v.icon
        } : (iconMap[v.icon] || ShieldCheck)
      }))
    }
  }

  // Default values if no data
  console.log('Using default core values')
  return {
    title: 'Core Values',
    subtitle: 'The principles that guide everything we do',
    list: [
      { icon: ShieldCheck, title: 'Safety First', description: 'Zero-compromise approach to workplace and operational safety' },
      { icon: Award, title: 'Quality Excellence', description: 'ISO 9001:2015 certified processes and international standards' },
      { icon: Users, title: 'Customer Focus', description: 'Dedicated to delivering beyond client expectations' },
      { icon: TrendingUp, title: 'Innovation Driven', description: 'Continuous investment in R&D and cutting-edge technology' }
    ]
  }
})

// Certifications from About page
const certifications = [
  'ISO 9001:2015', 'ISO 14001:2015', 'ISO 45001:2018',
  'IEC 60076', 'IEEE Standards', 'BPDB Approved'
]

// Product Categories from Products page - now using dynamic data from API
const productCategoryList = computed(() => {
  // Start with "All Products" as the first category
  const categories = [
    { id: 'all', name: 'All Products', icon: Settings, isSvg: false }
  ]

  // Add dynamic categories from API if available
  if (productCategoriesData.value && productCategoriesData.value.length > 0) {
    console.log('Using product categories from API:', productCategoriesData.value)
    productCategoriesData.value.forEach(category => {
      let iconComponent = Settings
      let isSvg = false

      if (category.icon) {
        // If icon contains SVG HTML, use it as template
        if (category.icon.includes('<svg')) {
          categories.push({
            id: category.id,
            name: category.name,
            icon: { template: category.icon },
            isSvg: true
          })
          return
        }
        // Otherwise try to map icon name to component
        iconComponent = iconMap[category.icon] || Settings
      }

      categories.push({
        id: category.id,
        name: category.name,
        icon: iconComponent,
        isSvg: false
      })
    })
  } else {
    // Fallback to hardcoded categories if no API data
    console.log('Using fallback product categories')
    categories.push(
      { id: 'transformers', name: 'Transformers', icon: Zap, isSvg: false },
      { id: 'switchgear', name: 'Switchgear', icon: Settings, isSvg: false },
      { id: 'renewables', name: 'Renewables', icon: Wind, isSvg: false }
    )
  }

  return categories
})

// Featured Products from Products page - now using dynamic data from API
const featuredProducts = computed(() => {
  if (featuredProductsData.value && featuredProductsData.value.length > 0) {
    console.log('Using featured products from API:', featuredProductsData.value)
    return featuredProductsData.value.map(product => {
      return {
        id: product.id,
        name: product.name,
        category: product.category,
        description: product.description,
        specifications: Array.isArray(product.specifications) ? product.specifications : [],
        image: product.image || 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800'
      }
    })
  }

  // Fallback to hardcoded products if no API data
  console.log('Using fallback featured products')
  return [
    {
      id: 1,
      name: 'Power Transformer 250 MVA',
      category: 'transformers',
      description: 'High-capacity power transformer for utility-scale applications',
      specifications: ['250 MVA', '230/132 kV', 'ONAN/ONAF Cooling'],
      image: 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800'
    },
    {
      id: 2,
      name: 'Gas Insulated Switchgear',
      category: 'switchgear',
      description: 'SF6 gas-insulated switchgear for compact substation solutions',
      specifications: ['Up to 400 kV', '2500-4000 A', '40 kA'],
      image: 'https://images.unsplash.com/photo-1544724569-5f546fa6629c?auto=format&fit=crop&q=80&w=800'
    },
    {
      id: 3,
      name: 'Solar Inverter System',
      category: 'renewables',
      description: 'Grid-tied solar inverters for utility-scale solar farms',
      specifications: ['100-1000 kW', 'MPPT tracking', 'Grid support'],
      image: 'https://images.unsplash.com/photo-1509391366360-fe5bb658589d?auto=format&fit=crop&q=80&w=800'
    }
  ]
})

const filteredFeaturedProducts = computed(() => {
  if (activeProductCategory.value === 'all') return featuredProducts.value
  return featuredProducts.value.filter(p => p.category === activeProductCategory.value)
})

// Services from Services page
const mainServices = [
  {
    icon: Cog,
    title: 'EPC Contracting',
    description: 'Full-scope Engineering, Procurement, and Construction services for power infrastructure projects',
    features: ['Turnkey Solutions', 'Project Management', 'Quality Assurance']
  },
  {
    icon: Wrench,
    title: 'Maintenance Services',
    description: 'Comprehensive maintenance and support for all power systems and equipment',
    features: ['24/7 Emergency Support', 'Preventive Maintenance', 'Condition Monitoring']
  }
]

// Service Process from Services page
const serviceProcess = [
  { step: '01', title: 'Consultation', description: 'Understanding your requirements and developing customized solutions' },
  { step: '02', title: 'Design', description: 'Engineering detailed designs and specifications for optimal performance' },
  { step: '03', title: 'Implementation', description: 'Executing projects with precision and adherence to timelines' },
  { step: '04', title: 'Support', description: 'Providing ongoing maintenance and technical support throughout lifecycle' }
]

// Solutions from Solutions page (abbreviated)
const keySolutions = [
  {
    icon: Zap,
    title: 'EPC Solutions',
    description: 'Turnkey Engineering, Procurement, and Construction services for power infrastructure',
    features: ['Power Plant EPC', 'Substation EPC', 'Transmission Line EPC']
  },
  {
    icon: Building2,
    title: 'MEP Solutions',
    description: 'Integrated Mechanical, Electrical, and Plumbing services for buildings and facilities',
    features: ['Electrical Design', 'HVAC Systems', 'Fire Protection']
  }
]

// Industries from Solutions page - now using dynamic service categories
const industries = computed(() => {
  if (serviceCategoriesData.value && serviceCategoriesData.value.length > 0) {
    console.log('Using service categories from API:', serviceCategoriesData.value)
    return serviceCategoriesData.value.map(category => {
      // Map icon names to components, default to Zap if not found
      let iconComponent = Zap
      if (category.icon) {
        // If icon contains SVG HTML, store it as template
        if (category.icon.includes('<svg')) {
          return {
            name: category.name,
            icon: { template: category.icon },
            isSvg: true
          }
        }
        // Otherwise try to map icon name to component
        iconComponent = iconMap[category.icon] || Zap
      }

      return {
        name: category.name,
        icon: iconComponent,
        isSvg: false
      }
    })
  }

  // Fallback to hardcoded industries if no API data
  console.log('Using fallback industries')
  return [
    { name: 'Power Generation', icon: Zap, isSvg: false },
    { name: 'Textile', icon: Factory, isSvg: false },
    { name: 'Pharmaceuticals', icon: Building2, isSvg: false },
    { name: 'Construction', icon: Building2, isSvg: false },
    { name: 'Food Processing', icon: Factory, isSvg: false },
    { name: 'Telecom', icon: Zap, isSvg: false }
  ]
})

// Testimonials (new section) - using dynamic data from API
const testimonials = computed(() => {
  return testimonialsData.value?.testimonials || []
})

// Partners/Clients - now using dynamic data
const partners = computed(() => {
  // Use dedicated API data if available
  if (partnersData.value?.list) {
    console.log('Using partners API data:', partnersData.value)
    return {
      title: partnersData.value.title || 'Trusted by Industry Leaders',
      subtitle: partnersData.value.subtitle || 'Proud partner to government agencies, multinational corporations, and leading enterprises',
      list: partnersData.value.list
    }
  }

  // Fallback to homepageData for backwards compatibility
  if (homepageData.value?.partners?.list) {
    console.log('Using homepageData partners as fallback:', homepageData.value.partners)
    const p = homepageData.value.partners
    return {
      title: p.title || 'Trusted by Industry Leaders',
      subtitle: p.subtitle || 'Proud partner to government agencies, multinational corporations, and leading enterprises',
      list: p.list
    }
  }

  // Default values if no data
  console.log('Using default partners values')
  return {
    title: 'Trusted by Industry Leaders',
    subtitle: 'Proud partner to government agencies, multinational corporations, and leading enterprises',
    list: [
      { name: 'BPDB', logo: '🏭' },
      { name: 'ADB', logo: '🏦' },
      { name: 'World Bank', logo: '🌐' },
      { name: 'BERC', logo: '⚡' },
      { name: 'IEC', logo: '🔌' },
      { name: 'IEEE', logo: '📡' }
    ]
  }
})

const contactCta = computed(() => {
  // Use dedicated API data if available
  if (contactCtaData.value?.title) {
    console.log('Using contact CTA API data:', contactCtaData.value)
    return {
      title: contactCtaData.value.title || 'Ready to Power Your Success?',
      description: contactCtaData.value.description || "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs.",
      button_text: contactCtaData.value.button_text || 'Get in Touch',
      button_link: contactCtaData.value.button_link || '/contact'
    }
  }

  // Fallback to homepageData for backwards compatibility
  if (homepageData.value?.cta_section) {
    console.log('Using homepageData contact CTA as fallback:', homepageData.value.cta_section)
    const cta = homepageData.value.cta_section
    return {
      title: cta.title || 'Ready to Power Your Success?',
      description: cta.description || "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs.",
      button_text: cta.button_text || 'Get in Touch',
      button_link: cta.button_link || '/contact'
    }
  }

  // Default values if no data
  console.log('Using default contact CTA values')
  return {
    title: 'Ready to Power Your Success?',
    description: "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs. Our team is ready to provide expert consultation and tailored solutions.",
    button_text: 'Get in Touch',
    button_link: '/contact'
  }
})
</script>

<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-24 md:pt-20 pb-32 md:pb-40 overflow-hidden">
      <!-- Background Image -->
      <div class="absolute inset-0 z-0">
        <img
          :src="getImageUrl(heroData?.background_image || heroData?.seo_attributes?.src || homepageData?.hero?.background_image || '/hero.png')"
          class="w-full h-full object-cover scale-105"
          alt="Power Infrastructure"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark via-industrial-dark/80 to-transparent"></div>
        <div class="absolute inset-0 bg-industrial-dark/40"></div>
      </div>

      <!-- Content -->
      <div class="relative z-10 max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
        <div v-motion :initial="{ opacity: 0, x: -50 }" :enter="{ opacity: 1, x: 0 }">
          <div class="flex items-center gap-3 mb-6 md:mb-8">
            <div class="h-px w-8 md:w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] md:tracking-[0.5em] text-[10px] md:text-xs">
              {{ heroData?.badge || homepageData?.hero?.subtitle || 'Leaders in Energy' }}
            </span>
          </div>
          <h1 class="text-3xl sm:text-4xl md:text-[4em] font-display font-black uppercase italic leading-[1.1] mb-8 text-white drop-shadow-[0_5px_15px_rgba(0,0,0,0.5)]">
            {{ heroData?.title || homepageData?.hero?.title || 'POWERING BANGLADESH' }}
          </h1>
          <p class="text-sm md:text-base text-slate-200 max-w-lg mb-8 md:mb-10 leading-relaxed font-medium">
            {{ heroData?.description || homepageData?.hero?.description || 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.' }}
          </p>
          <div class="flex flex-wrap gap-4 md:gap-5">
            <a :href="heroData?.primary_cta?.link || heroData?.cta_link || homepageData?.hero?.cta_link || '/projects'" class="bg-industrial-blue text-white px-6 md:px-10 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs flex items-center gap-3 hover:bg-industrial-red transition-all shadow-2xl hover:scale-105 active:scale-95">
              {{ heroData?.primary_cta?.text || heroData?.cta_text || homepageData?.hero?.cta_text || 'EXPLORE CATALOG' }} <ChevronRight class="w-4 h-4" />
            </a>
            <a :href="heroData?.secondary_cta?.link || '/about'" class="bg-white/5 border-2 border-white/20 text-white px-6 md:px-10 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs backdrop-blur-md hover:bg-white/20 transition-all hover:border-white">
              {{ heroData?.secondary_cta?.text || 'CORPORATE PROFILE' }}
            </a>
          </div>
        </div>

        <!-- Floating Cards -->
        <div
          class="hidden lg:grid grid-cols-2 gap-4 relative z-10"
          v-motion
          :initial="{ opacity: 0, scale: 0.8 }"
          :enter="{ opacity: 1, scale: 1 }"
          :delay="400"
        >
          <div class="glass-panel p-6 rounded-xl hover:-translate-y-2 transition-all duration-500 cursor-pointer group flex items-center gap-4">
            <div class="w-16 h-16 flex-shrink-0 flex items-center justify-center">
              <Settings class="w-12 h-12 text-industrial-blue group-hover:rotate-90 transition-transform duration-700" />
            </div>
            <div>
              <h3 class="font-bold mb-1">Turnkey EPC</h3>
              <p class="text-[10px] text-slate-400">End-to-end project management.</p>
            </div>
          </div>
          <div class="glass-panel p-6 rounded-xl hover:-translate-y-2 transition-all duration-500 cursor-pointer group flex items-center gap-4">
            <div class="w-16 h-16 flex-shrink-0 flex items-center justify-center">
              <ShieldCheck class="w-12 h-12 text-industrial-blue group-hover:scale-110 transition-transform" />
            </div>
            <div>
              <h3 class="font-bold mb-1">Smart Grid</h3>
              <p class="text-[10px] text-slate-400">Class 5 risk mitigation integrated.</p>
            </div>
          </div>
          <div class="col-span-2 glass-panel p-6 rounded-xl flex items-center justify-between hover:bg-industrial-blue/10 transition-colors">
            <div class="flex items-center gap-4">
              <div class="w-16 h-16 flex-shrink-0 flex items-center justify-center">
                <Activity class="w-12 h-12 text-industrial-blue animate-pulse" />
              </div>
              <div>
                <h3 class="text-2xl font-display font-black flex items-center gap-2">
                  ISO <span class="text-[10px] text-industrial-blue bg-industrial-blue/10 px-2 py-0.5 rounded uppercase">9001:2015</span>
                </h3>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Certified Compliance</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Category Bar -->
      <div class="absolute bottom-0 w-full bg-white/5 backdrop-blur-3xl border-t border-white/10 overflow-x-auto">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 divide-x divide-white/10 min-w-[600px] md:min-w-0">
          <div v-for="cat in productCategories" :key="cat.name" class="py-6 md:py-8 px-0 group cursor-pointer hover:bg-white/5 transition-colors">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 flex items-center justify-center">
                <!-- Render SVG if icon contains HTML, otherwise use component -->
                <div v-if="cat.isSvg" v-html="cat.icon" class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors"></div>
                <component v-else :is="cat.icon" class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" />
              </div>
              <div>
                <div class="text-[8px] md:text-[10px] text-slate-500 font-black uppercase tracking-widest">{{ cat.count }} Models</div>
                <div class="font-display font-black uppercase text-base md:text-xl group-hover:text-industrial-blue transition-colors leading-tight">{{ cat.name }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Brand Statement / Trust Section -->
    <section class="py-20 md:py-32 bg-white text-industrial-dark">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-center">
          <div v-motion-slide-visible-left>
             <h2 class="text-4xl md:text-5xl font-display font-black uppercase leading-[0.9] mb-8 text-industrial-dark">
               <span v-html="formatBrandTitle(brandStatements?.title || homepageData?.brand_statement?.title || 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING')"></span>
             </h2>
             <p class="text-slate-600 text-base md:text-lg leading-relaxed mb-8">
               {{ brandStatements?.description || homepageData?.brand_statement?.description || 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.' }}
             </p>
             <div class="grid grid-cols-2 gap-8 md:gap-12">
               <div v-for="stat in stats" :key="stat.label" class="border-l-4 border-industrial-blue pl-4 md:pl-6 py-2">
                 <div class="text-3xl md:text-4xl font-display font-black text-industrial-blue">{{ stat.value }}</div>
                 <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ stat.label }}</div>
               </div>
             </div>
          </div>
          <div class="relative group overflow-hidden rounded-sm h-[400px] md:h-[500px]" v-motion-slide-visible-right>
            <img :src="getImageUrl(brandStatements?.image || homepageData?.brand_statement?.image_url)" class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110" />
            <div class="absolute inset-0 bg-industrial-blue/10 mix-blend-multiply"></div>
            <div class="absolute bottom-6 md:bottom-10 left-6 md:left-10 p-6 md:p-8 bg-industrial-blue text-white shadow-2xl max-w-[200px] md:max-w-xs transition-all opacity-0 md:opacity-100 group-hover:opacity-100">
               <div class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 opacity-70">{{ brandStatements?.overlay_title || homepageData?.brand_statement?.overlay_title || 'Core Reliability' }}</div>
               <div class="text-xl md:text-2xl font-display font-bold italic leading-tight">"{{ brandStatements?.overlay_text || homepageData?.brand_statement?.overlay_text || 'Zero Downtime Operation Protocols' }}"</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Projects Preview -->
    <section class="py-20 md:py-32 bg-industrial-dark text-white relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 md:gap-16 items-center mb-12">
          <div class="lg:col-span-4" v-motion-slide-visible-left">
             <span class="text-industrial-red font-black uppercase tracking-widest text-[10px] block mb-4 underline decoration-2 underline-offset-4 leading-8">{{ homepageData?.projects_subtitle || 'Featured Deployments' }}</span>
             <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic leading-[0.9] mb-6 text-gradient-blue">{{ homepageData?.projects_title || 'THE ENERGY MATRIX' }}</h2>
             <p class="text-slate-400 leading-relaxed mb-8 text-sm md:text-base">
               Engineering large-scale infrastructure with interactive project tracking and real-time performance monitoring.
             </p>

             <!-- Interactive Filter Buttons -->
             <div class="flex flex-wrap gap-2 mb-8">
               <button
                 v-for="category in projectCategoryList"
                 :key="category.id"
                 @click="setProjectFilter(category.slug)"
                 :class="projectFilter === category.slug ? 'bg-industrial-blue text-white' : 'bg-white/5 text-slate-400 hover:bg-white/10'"
                 class="px-4 py-2 text-[10px] font-black uppercase tracking-widest border border-industrial-blue/20 transition-all rounded-sm"
               >
                 {{ category.name }}
               </button>
             </div>
          </div>

          <!-- Project Grid -->
          <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-6" v-motion-slide-visible-right>
             <div
               v-for="(project, idx) in filteredProjects"
               :key="idx"
               @click="openProjectModal(project)"
               class="relative group rounded-sm overflow-hidden aspect-[10/12] shadow-2xl cursor-pointer transform transition-all duration-500 hover:scale-[1.02] hover:shadow-industrial-blue/20"
             >
                <img
                  :src="getImageUrl(project.image)"
                  class="w-full h-full object-cover grayscale brightness-75 transition-all duration-700 group-hover:grayscale-0 group-hover:brightness-100 group-hover:scale-110"
                  :alt="project.title"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark via-industrial-dark/40 to-transparent"></div>
                <div class="absolute inset-0 border-4 md:border-8 border-transparent group-hover:border-industrial-blue/30 transition-all duration-500"></div>
                <div class="absolute top-4 right-4 bg-industrial-blue/90 backdrop-blur-md px-3 py-1 rounded-sm">
                  <div class="text-[10px] font-black uppercase tracking-widest text-white">{{ project.capacity }}</div>
                </div>
                <div class="absolute bottom-0 left-0 p-6 md:p-8 w-full transition-all duration-500">
                   <div class="flex items-center justify-between mb-3">
                     <div class="text-[10px] text-industrial-blue font-black uppercase tracking-[0.4em] drop-shadow-lg">{{ project.type }}</div>
                     <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-industrial-blue transition-colors">
                       <ArrowUpRight class="w-4 h-4 text-white group-hover:rotate-45 transition-transform duration-300" />
                     </div>
                   </div>
                   <h3 class="text-2xl md:text-3xl font-display font-black uppercase italic mb-3 leading-tight text-white">{{ project.title }}</h3>
                   <div class="flex items-center gap-2 text-[10px] text-slate-400 group-hover:text-white transition-colors">
                     <MapPin class="w-3 h-3" />
                     <span class="font-medium">{{ project.location }}</span>
                   </div>
                </div>
             </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Mission & Vision Section (from About page) -->
    <section class="py-20 md:py-32 bg-white text-industrial-dark">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16">
          <div v-for="(item, index) in missionVision" :key="index" v-motion-slide-visible :class="index % 2 === 0 ? 'left' : 'right'">
            <div class="flex items-center gap-3 mb-6">
              <component :is="item.icon" class="w-8 h-8 text-industrial-blue" />
              <h2 class="text-3xl md:text-4xl font-display font-black uppercase italic text-industrial-dark">{{ item.title }}</h2>
            </div>
            <p class="text-base md:text-lg text-slate-600 leading-relaxed mb-6">
              {{ item.description }}
            </p>
            <ul class="space-y-4">
              <li v-for="(point, idx) in item.points" :key="idx" class="flex items-start gap-3">
                <CheckCircle class="w-6 h-6 text-industrial-blue flex-shrink-0 mt-1" />
                <span class="text-slate-700">{{ point }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Company Timeline (from About page - abbreviated) -->
    <section class="py-20 md:py-32 bg-industrial-light">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-industrial-dark">
            {{ journeyData?.title?.split(' ')[0] || homepageData?.journey?.title?.split(' ')[0] || 'Our' }} <span class="text-industrial-blue">{{ journeyData?.title?.split(' ').slice(1).join(' ') || homepageData?.journey?.title?.split(' ').slice(1).join(' ') || 'Journey' }}</span>
          </h2>
          <p class="text-slate-600 text-lg max-w-2xl mx-auto">
            {{ journeyData?.subtitle || homepageData?.journey?.subtitle || 'Four decades of excellence in powering Bangladesh\'s development' }}
          </p>
        </div>

        <div class="relative">
          <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-industrial-blue/20 hidden md:block"></div>
          <div class="space-y-12 md:space-y-16">
            <div
              v-for="(item, index) in timeline"
              :key="index"
              class="relative flex items-center"
              :class="index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <div class="w-full md:w-5/12" :class="index % 2 === 0 ? 'md:pr-12' : 'md:pl-12'">
                <div class="bg-white p-6 md:p-8 rounded-lg shadow-xl hover:shadow-2xl transition-shadow">
                  <div class="text-industrial-blue font-black text-xl md:text-2xl mb-2">{{ item.year }}</div>
                  <h3 class="text-lg md:text-xl font-bold mb-3 text-industrial-dark">{{ item.title }}</h3>
                  <p class="text-slate-600 text-sm md:text-base">{{ item.description }}</p>
                </div>
              </div>
              <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-industrial-blue rounded-full border-4 border-white shadow-lg"></div>
              <div class="w-0 md:w-5/12"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Core Values (from About page) -->
    <section class="py-20 md:py-32 bg-industrial-dark text-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-white" v-html="formatBrandTitle(coreValues.title)">
          </h2>
          <p class="text-slate-400 text-lg max-w-2xl mx-auto">
            {{ coreValues.subtitle }}
          </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
          <div
            v-for="(value, index) in coreValues.list"
            :key="index"
            class="glass-panel p-6 md:p-8 rounded-lg hover:bg-industrial-blue/10 transition-colors group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <!-- Icon - SVG template or component -->
            <div v-if="value.icon?.template" v-html="value.icon.template" class="w-10 h-10 md:w-12 md:h-12 text-industrial-blue mb-4 md:mb-6 group-hover:scale-110 transition-transform"></div>
            <component v-else :is="value.icon" class="w-10 h-10 md:w-12 md:h-12 text-industrial-blue mb-4 md:mb-6 group-hover:scale-110 transition-transform" />
            <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4 text-white">{{ value.title }}</h3>
            <p class="text-slate-400 text-xs md:text-sm leading-relaxed">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Certifications (from About page) -->
    <section class="py-16 md:py-24 bg-white text-industrial-dark">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12" v-motion-slide-visible-bottom>
          <h2 class="text-3xl md:text-4xl font-display font-black uppercase italic mb-6 text-industrial-dark">
            Certifications & <span class="text-industrial-blue">Standards</span>
          </h2>
          <p class="text-slate-600 text-base md:text-lg max-w-2xl mx-auto">
            Internationally recognized certifications ensuring quality and safety
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
          <div
            v-for="(cert, index) in certifications"
            :key="index"
            class="bg-industrial-light p-4 md:p-6 rounded-lg text-center hover:bg-industrial-blue hover:text-white transition-all group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="font-black uppercase text-[10px] md:text-xs tracking-wider">{{ cert }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products (from Products page) -->
    <section class="py-20 md:py-32 bg-industrial-light">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12" v-motion-slide-visible-bottom>
          <div class="flex items-center justify-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] text-[10px] md:text-xs">Our Products</span>
            <div class="h-px w-12 bg-industrial-blue"></div>
          </div>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-industrial-dark">
            Engineering <span class="text-industrial-blue">Excellence</span>
          </h2>
          <p class="text-slate-600 text-base md:text-lg max-w-3xl mx-auto">
            Comprehensive portfolio of power systems and equipment designed for reliability, efficiency, and sustainability.
          </p>
        </div>

        <!-- Product Category Filter -->
        <div class="flex flex-wrap gap-3 md:gap-4 justify-center mb-12" v-motion-slide-visible-bottom>
          <button
            v-for="category in productCategoryList"
            :key="category.id"
            @click="activeProductCategory = category.id"
            class="flex items-center gap-2 px-4 md:px-6 py-2 md:py-3 rounded-sm font-bold uppercase text-[10px] md:text-xs tracking-wider transition-all"
            :class="activeProductCategory === category.id ? 'bg-industrial-blue text-white' : 'bg-white text-industrial-dark hover:bg-industrial-blue/10 shadow-md'"
          >
            <!-- Icon - SVG template or component -->
            <div v-if="category.isSvg && category.icon?.template" v-html="category.icon.template" class="w-4 h-4"></div>
            <component v-else :is="category.icon" class="w-4 h-4" />
            {{ category.name }}
          </button>
        </div>

        <!-- Products Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
          <div
            v-for="(product, index) in filteredFeaturedProducts"
            :key="product.id"
            class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="relative h-48 md:h-64 overflow-hidden">
              <img
                :src="getImageUrl(product.image)"
                :alt="product.name"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/80 to-transparent"></div>
              <div class="absolute top-4 right-4 bg-industrial-blue text-white px-3 py-1 rounded-full text-[10px] md:text-xs font-bold uppercase">
                {{ productCategoryList.find(c => c.id === product.category)?.name }}
              </div>
            </div>

            <div class="p-4 md:p-6">
              <h3 class="text-lg md:text-xl font-display font-black uppercase italic mb-3 text-industrial-dark group-hover:text-industrial-blue transition-colors">
                {{ product.name }}
              </h3>
              <p class="text-slate-600 text-xs md:text-sm mb-4 line-clamp-2">
                {{ product.description }}
              </p>

              <div class="mb-4">
                <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2">Key Specifications</div>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="(spec, idx) in product.specifications"
                    :key="idx"
                    class="bg-industrial-light text-industrial-dark px-2 md:px-3 py-1 rounded text-[10px] md:text-xs font-medium"
                  >
                    {{ spec }}
                  </span>
                </div>
              </div>

              <button class="w-full bg-industrial-blue text-white py-2 md:py-3 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs hover:bg-industrial-red transition-colors flex items-center justify-center gap-2 group-hover:gap-4">
                Learn More <ArrowRight class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>

        <div class="text-center mt-12" v-motion-slide-visible-bottom>
          <a href="/products" class="inline-flex items-center gap-3 bg-industrial-dark text-white px-8 md:px-12 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs hover:bg-industrial-blue transition-all shadow-2xl">
            View All Products <ArrowRight class="w-4 h-4" />
          </a>
        </div>
      </div>
    </section>

    <!-- Services Overview (from Services page) -->
    <section class="py-20 md:py-32 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <div class="flex items-center justify-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] text-[10px] md:text-xs">{{ homepageData?.services_subtitle || 'Our Services' }}</span>
            <div class="h-px w-12 bg-industrial-blue"></div>
          </div>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-industrial-dark">
            {{ homepageData?.services_title || 'Comprehensive Solutions' }}
          </h2>
          <p class="text-slate-600 text-base md:text-lg max-w-3xl mx-auto">
            End-to-end services from concept to commissioning, ensuring your power infrastructure operates at peak performance.
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 md:gap-8 mb-16">
          <div
            v-for="(service, index) in mainServices"
            :key="index"
            class="group p-6 md:p-8 rounded-lg border-2 border-slate-200 hover:border-industrial-blue transition-all duration-500 hover:shadow-2xl"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="flex items-start gap-4 md:gap-6">
              <div class="w-12 h-12 md:w-16 md:h-16 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-industrial-red transition-colors">
                <component :is="service.icon" class="w-6 h-6 md:w-8 md:h-8 text-white" />
              </div>
              <div class="flex-1">
                <h3 class="text-xl md:text-2xl font-display font-black uppercase italic mb-3 md:mb-4 text-industrial-dark group-hover:text-industrial-blue transition-colors">
                  {{ service.title }}
                </h3>
                <p class="text-slate-600 text-sm md:text-base mb-4 md:mb-6 leading-relaxed">
                  {{ service.description }}
                </p>
                <div>
                  <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2 md:mb-3">Key Features</div>
                  <div class="space-y-1 md:space-y-2">
                    <div
                      v-for="(feature, idx) in service.features"
                      :key="idx"
                      class="flex items-center gap-2 text-xs md:text-sm text-slate-700"
                    >
                      <CheckCircle class="w-3 h-3 md:w-4 md:h-4 text-industrial-blue flex-shrink-0" />
                      {{ feature }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Service Process -->
        <div class="bg-industrial-dark text-white p-8 md:p-12 rounded-lg" v-motion-slide-visible-bottom>
          <h3 class="text-2xl md:text-3xl font-display font-black uppercase italic text-center mb-8 md:mb-12 text-white">
            Our <span class="text-industrial-blue">Process</span>
          </h3>
          <div class="grid md:grid-cols-4 gap-6 md:gap-8">
            <div
              v-for="(step, index) in serviceProcess"
              :key="index"
              class="text-center"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <div class="text-4xl md:text-6xl font-display font-black text-industrial-blue/30 mb-3 md:mb-4">{{ step.step }}</div>
              <h4 class="text-base md:text-xl font-bold mb-2 md:mb-3 text-white">{{ step.title }}</h4>
              <p class="text-slate-400 text-xs md:text-sm leading-relaxed">{{ step.description }}</p>
            </div>
          </div>
        </div>

        <div class="text-center mt-12" v-motion-slide-visible-bottom>
          <a href="/services-and-solutions" class="inline-flex items-center gap-3 bg-industrial-blue text-white px-8 md:px-12 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs hover:bg-industrial-red transition-all shadow-2xl">
            All Services <ArrowRight class="w-4 h-4" />
          </a>
        </div>
      </div>
    </section>

    <!-- Key Solutions (from Solutions page - abbreviated) -->
    <section class="py-20 md:py-32 bg-industrial-light">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <div class="flex items-center justify-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] text-[10px] md:text-xs">Our Solutions</span>
            <div class="h-px w-12 bg-industrial-blue"></div>
          </div>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-industrial-dark">
            Engineering <span class="text-industrial-blue">Mastery</span>
          </h2>
          <p class="text-slate-600 text-base md:text-lg max-w-3xl mx-auto">
            Tailored solutions designed to meet the unique challenges of power infrastructure across diverse industries.
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 md:gap-8 mb-16">
          <div
            v-for="(solution, index) in keySolutions"
            :key="index"
            class="bg-white rounded-lg overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="grid md:grid-cols-2">
              <div class="relative h-48 md:h-auto">
                <img
                  :src="solution.image"
                  :alt="solution.title"
                  class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark/80 to-transparent md:bg-gradient-to-t"></div>
                <div class="absolute top-4 left-4 bg-industrial-blue text-white p-2 md:p-3 rounded-lg">
                  <component :is="solution.icon" class="w-5 h-5 md:w-6 md:h-6" />
                </div>
              </div>

              <div class="p-6 md:p-8 flex flex-col">
                <h3 class="text-xl md:text-2xl font-display font-black uppercase italic mb-3 md:mb-4 text-industrial-dark hover:text-industrial-blue transition-colors">
                  {{ solution.title }}
                </h3>
                <p class="text-slate-600 text-xs md:text-sm mb-4 md:mb-6 leading-relaxed">
                  {{ solution.description }}
                </p>

                <div class="mb-4 md:mb-6">
                  <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2 md:mb-3">Core Features</div>
                  <div class="space-y-1 md:space-y-2">
                    <div
                      v-for="(feature, idx) in solution.features"
                      :key="idx"
                      class="flex items-center gap-2 text-xs md:text-sm text-slate-700"
                    >
                      <div class="w-1.5 h-1.5 rounded-full bg-industrial-blue"></div>
                      {{ feature }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Industries Served -->
        <div class="bg-industrial-dark text-white p-8 md:p-12 rounded-lg" v-motion-slide-visible-bottom>
          <h3 class="text-2xl md:text-3xl font-display font-black uppercase italic text-center mb-8 md:mb-12 text-white">
            Industries We <span class="text-industrial-blue">Serve</span>
          </h3>
          <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
            <div
              v-for="(industry, index) in industries"
              :key="index"
              class="glass-panel p-4 md:p-6 rounded-lg text-center hover:bg-industrial-blue/10 transition-colors group"
              v-motion-slide-visible-bottom
              :delay="index * 100"
            >
              <!-- Icon - SVG template or component -->
              <div v-if="industry.isSvg && industry.icon?.template" v-html="industry.icon.template" class="w-8 h-8 md:w-12 md:h-12 text-industrial-blue mx-auto mb-3 md:mb-4 group-hover:scale-110 transition-transform industries-icon"></div>
              <component v-else :is="industry.icon" class="w-8 h-8 md:w-12 md:h-12 text-industrial-blue mx-auto mb-3 md:mb-4 group-hover:scale-110 transition-transform" />
              <div class="font-bold uppercase text-[10px] md:text-xs tracking-wider">{{ industry.name }}</div>
            </div>
          </div>
        </div>

        <div class="text-center mt-12" v-motion-slide-visible-bottom>
          <a href="/services-and-solutions" class="inline-flex items-center gap-3 bg-industrial-blue text-white px-8 md:px-12 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs hover:bg-industrial-red transition-all shadow-2xl">
            All Solutions <ArrowRight class="w-4 h-4" />
          </a>
        </div>
      </div>
    </section>

    <!-- Testimonials (new section) -->
    <section class="py-20 md:py-32 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" v-motion-slide-visible-bottom>
          <div class="flex items-center justify-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] text-[10px] md:text-xs">{{ testimonialsData?.subtitle || 'Testimonials' }}</span>
            <div class="h-px w-12 bg-industrial-blue"></div>
          </div>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-industrial-dark">
            {{ testimonialsData?.title || 'What Our Clients Say' }}
          </h2>
          <p class="text-slate-600 text-base md:text-lg max-w-3xl mx-auto">
            {{ testimonialsData?.description || 'Trusted by leading organizations across Bangladesh and beyond' }}
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 md:gap-8">
          <div
            v-for="(testimonial, index) in testimonials"
            :key="index"
            class="bg-industrial-light p-6 md:p-8 rounded-lg hover:shadow-xl transition-all"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <div class="flex items-center gap-1 mb-4">
              <Star v-for="n in testimonial.rating" :key="n" class="w-4 h-4 md:w-5 md:h-5 fill-yellow-400 text-yellow-400" />
            </div>
            <p class="text-slate-700 text-sm md:text-base leading-relaxed mb-6 italic">
              "{{ testimonial.content }}"
            </p>
            <div class="border-t border-slate-300 pt-4">
              <div class="font-bold text-industrial-dark">{{ testimonial.name }}</div>
              <div class="text-xs md:text-sm text-slate-600">{{ testimonial.position }}</div>
              <div class="text-[10px] md:text-xs text-industrial-blue font-medium">{{ testimonial.company }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Partners/Clients (new section) -->
    <section class="py-16 md:py-24 bg-industrial-light">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12" v-motion-slide-visible-bottom>
          <h2 class="text-3xl md:text-4xl font-display font-black uppercase italic mb-6 text-industrial-dark">
            {{ partners.title || 'Trusted by' }} <span class="text-industrial-blue">Industry Leaders</span>
          </h2>
          <p class="text-slate-600 text-base md:text-lg max-w-2xl mx-auto">
            {{ partners.subtitle || 'Proud partner to government agencies, multinational corporations, and leading enterprises' }}
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 md:gap-8">
          <div
            v-for="(partner, index) in partners.list"
            :key="index"
            class="bg-white p-6 md:p-8 rounded-lg flex flex-col items-center justify-center shadow-lg hover:shadow-xl transition-all group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <!-- Display emoji logo if it's an emoji -->
            <div
              v-if="isEmoji(partner.logo)"
              class="text-4xl md:text-5xl mb-3 group-hover:scale-110 transition-transform"
            >
              {{ partner.logo }}
            </div>
            <!-- Display image logo if it's an image URL -->
            <img
              v-else
              :src="getImageUrl(partner.logo)"
              :alt="partner.name"
              class="h-12 md:h-16 w-auto object-contain mb-3 group-hover:scale-110 transition-transform"
            />
            <div class="font-black uppercase text-xs md:text-sm tracking-wider text-slate-700 group-hover:text-industrial-blue transition-colors">{{ partner.name }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact CTA (new section) -->
    <section class="py-20 md:py-32 bg-industrial-blue text-white relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark/20 to-transparent"></div>
      <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <div v-motion-slide-visible-bottom>
          <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
            {{ contactCta.title }}
          </h2>
          <p class="text-lg md:text-xl mb-12 text-industrial-100 max-w-3xl mx-auto">
            {{ contactCta.description }}
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a :href="contactCta.button_link" class="inline-flex items-center justify-center gap-3 bg-white text-industrial-blue px-8 md:px-12 py-4 md:py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
              {{ contactCta.button_text }} <Briefcase class="w-5 h-5" />
            </a>
            <a href="/contact" class="inline-flex items-center justify-center gap-3 bg-transparent border-2 border-white text-white px-8 md:px-12 py-4 md:py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-white hover:text-industrial-blue transition-all">
              Contact Us <Phone class="w-5 h-5" />
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Project Modal -->
    <Transition
      enter-active-class="transition-all duration-300"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition-all duration-200"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-if="selectedProject"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-8"
        @click.self="closeProjectModal"
      >
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="closeProjectModal"></div>
        <div class="relative bg-industrial-dark border border-industrial-blue/20 rounded-lg shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-y-auto">
           <button @click="closeProjectModal" class="absolute top-4 right-4 z-10 w-10 h-10 bg-industrial-blue rounded-full flex items-center justify-center text-white hover:bg-industrial-red transition-colors">
             <X class="w-5 h-5" />
           </button>
           <div class="grid md:grid-cols-2">
             <div class="relative h-64 md:h-auto">
               <img :src="getImageUrl(selectedProject.image)" class="w-full h-full object-cover" :alt="selectedProject.title" />
               <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark via-transparent to-transparent md:bg-gradient-to-r"></div>
               <div class="absolute top-4 left-4 bg-industrial-red text-white px-4 py-2 rounded-sm">
                 <div class="text-[10px] font-black uppercase tracking-widest">{{ selectedProject.capacity }}</div>
               </div>
             </div>
             <div class="p-6 md:p-10">
               <div class="text-[10px] text-industrial-blue font-black uppercase tracking-[0.4em] mb-3">{{ selectedProject.type }}</div>
               <h3 class="text-3xl md:text-4xl font-display font-black uppercase italic mb-4 leading-tight">{{ selectedProject.title }}</h3>
               <p class="text-slate-300 leading-relaxed mb-8">{{ selectedProject.description }}</p>
               <div class="grid grid-cols-2 gap-4 mb-8">
                 <div class="bg-white/5 border border-white/10 rounded-sm p-4">
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Location</div>
                    <div class="text-sm font-bold flex items-center gap-2">
                      <MapPin class="w-4 h-4 text-industrial-blue" />
                      {{ selectedProject.location }}
                    </div>
                 </div>
                 <div class="bg-white/5 border border-white/10 rounded-sm p-4">
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Completion</div>
                    <div class="text-sm font-bold">{{ selectedProject.completion }}</div>
                 </div>
               </div>
               <div class="mb-8">
                 <h4 class="text-[10px] font-black uppercase tracking-widest text-industrial-blue mb-3">Key Highlights</h4>
                 <div class="space-y-2">
                   <div v-for="(highlight, idx) in selectedProject.highlights" :key="idx" class="flex items-center gap-3 text-sm">
                     <div class="w-2 h-2 rounded-full bg-industrial-blue"></div>
                     <span class="text-slate-300">{{ highlight }}</span>
                   </div>
                 </div>
               </div>
               <div class="grid grid-cols-3 gap-4">
                 <div class="text-center">
                   <div class="text-2xl font-display font-black text-industrial-blue">{{ selectedProject.stats.efficiency }}%</div>
                   <div class="text-[8px] font-black uppercase tracking-widest text-slate-500 mt-1">Efficiency</div>
                 </div>
                 <div class="text-center">
                   <div class="text-2xl font-display font-black text-industrial-blue">{{ selectedProject.stats.uptime }}%</div>
                   <div class="text-[8px] font-black uppercase tracking-widest text-slate-500 mt-1">Uptime</div>
                 </div>
                 <div class="text-center">
                   <div class="text-2xl font-display font-black text-green-400">{{ selectedProject.stats.co2 }}</div>
                   <div class="text-[8px] font-black uppercase tracking-widest text-slate-500 mt-1">CO₂ Impact</div>
                 </div>
               </div>
             </div>
           </div>
        </div>
      </div>
    </Transition>
  </div>
</template>


<style scoped>
/* Core values SVG styling */
:deep(.glass-panel svg) {
  width: 100%;
  height: 100%;
  display: block;
}

/* Industries icons SVG styling - make fills white */
:deep(.industries-icon svg path) {
  fill: #ffffff !important;
}

:deep(.industries-icon svg g) {
  fill: #ffffff !important;
}
</style>

