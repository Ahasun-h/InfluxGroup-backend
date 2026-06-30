<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import {
  Zap,
  Menu,
  X,
  ChevronRight,
  ChevronDown,
  ArrowRight,
  Search,
  Phone,
  Mail,
  Globe,
  Briefcase,
  Users,
  FileText,
  Settings,
  ShieldCheck
} from 'lucide-vue-next'
import FloatingQuoteButton from '../components/FloatingQuoteButton.vue'
import logoWhite from '@/assets/logo.png'
import logoBlack from '@/assets/logo-black.png'
import { pageService, footerService } from '../services/content'

const router = useRouter()
const route = useRoute()
const isMenuOpen = ref(false)
const scrolled = ref(false)
const activeDropdown = ref(null)
const isSearchOpen = ref(false)
const searchQuery = ref('')
const lastScrollY = ref(0)
const isHeaderHidden = ref(false)

// Pages for footer "Our Services" section
const pagesData = ref(null)

// Footer data
const footerData = ref(null)

// Route name mapping for breadcrumb
const routeNameMap = {
  '/services-and-solutions': 'Services & Solutions',
  '/services': 'Services',
  '/solutions': 'Solutions',
  '/products': 'Products',
  '/projects': 'Projects',
  '/news': 'News & Update',
  '/about': 'About',
  '/contact': 'Contact',
  '/gallery': 'Gallery'
}

// Desktop currentNavigation (full menu)
const desktopNavigation = [
  {
    name: 'Home',
    path: '/',
    icon: Zap
  },
  {
    name: 'About',
    path: '/about',
    icon: Users
  },
  {
    name: 'Products',
    path: '/products',
    icon: Settings,
    hasDropdown: true,
    dropdownItems: [
      { name: 'Power Transformers', path: '/products?category=transformers', description: 'High-capacity transformers' },
      { name: 'Switchgear', path: '/products?category=switchgear', description: 'MV & LV switchgear systems' },
      { name: 'Renewables', path: '/products?category=renewables', description: 'Solar & wind solutions' },
      { name: 'Automation', path: '/products?category=automation', description: 'Industrial automation' },
      { name: 'View All Products', path: '/products', highlight: true }
    ]
  },
  {
    name: 'Projects',
    path: '/projects',
    icon: Briefcase
  },
  {
    name: 'Services & Solutions',
    path: '/services-and-solutions',
    icon: Settings
  },
  {
    name: 'News & Update',
    path: '/news',
    icon: FileText
  },
  {
    name: 'Contact',
    path: '/contact',
    icon: Mail,
    highlight: true
  }
]

// Laptop/tablet currentNavigation (simplified)
const laptopNavigation = [
  {
    name: 'Home',
    path: '/',
    icon: Zap
  },
  {
    name: 'About',
    path: '/about',
    icon: Users
  },
  {
    name: 'Products',
    path: '/products',
    icon: Settings,
    hasDropdown: true,
    dropdownItems: [
      { name: 'Transformers', path: '/products?category=transformers' },
      { name: 'Switchgear', path: '/products?category=switchgear' },
      { name: 'Renewables', path: '/products?category=renewables' },
      { name: 'View All', path: '/products', highlight: true }
    ]
  },
  {
    name: 'Projects',
    path: '/projects',
    icon: Briefcase
  },
  {
    name: 'More',
    hasDropdown: true,
    dropdownItems: [
      { name: 'Services & Solutions', path: '/services-and-solutions' },
      { name: 'News & Update', path: '/news' },
      { name: 'Gallery', path: '/gallery' },
      { name: 'Contact', path: '/contact', highlight: true }
    ]
  }
]

// Quick actions
const quickActions = [
  { name: 'Get a Quote', path: '/contact?type=quote', icon: Briefcase, primary: true },
  { name: 'Career', path: '/contact?type=career', icon: Users },
  { name: 'Support', path: '/contact?type=support', icon: Settings }
]

// Contact info
const contactInfo = {
  phone: '+880 2 987 6543',
  email: 'info@influxgroup.com',
  address: 'Dhaka, Bangladesh'
}

// Languages
const languages = [
  { code: 'en', name: 'English' },
  { code: 'bn', name: 'বাংলা' }
]

const currentLanguage = ref('en')
const isLaptopScreen = ref(false)
const currentNavigation = ref(laptopNavigation)

// Computed
const currentPath = computed(() => route.path)

// Update currentNavigation based on screen size
const updateNavigationForScreenSize = () => {
  const width = window.innerWidth

  if (width >= 1280) {
    // Large desktop - full currentNavigation
    currentNavigation.value = desktopNavigation
    isLaptopScreen.value = false
  } else if (width >= 1024) {
    // Laptop/tablet - simplified currentNavigation
    currentNavigation.value = laptopNavigation
    isLaptopScreen.value = true
  } else {
    // Mobile - use simplified currentNavigation
    currentNavigation.value = laptopNavigation
    isLaptopScreen.value = false
  }
}

// Methods
const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
  document.body.style.overflow = isMenuOpen.value ? 'hidden' : 'auto'
}

const closeMenu = () => {
  isMenuOpen.value = false
  activeDropdown.value = null
  document.body.style.overflow = 'auto'
}

const navigateTo = (path) => {
  router.push(path)
  closeMenu()
}

const toggleDropdown = (name) => {
  if (activeDropdown.value === name) {
    activeDropdown.value = null
  } else {
    activeDropdown.value = name
  }
}

const closeDropdown = () => {
  activeDropdown.value = null
}

const toggleSearch = () => {
  isSearchOpen.value = !isSearchOpen.value
  if (isSearchOpen.value) {
    setTimeout(() => {
      document.getElementById('search-input')?.focus()
    }, 100)
  }
}

const performSearch = () => {
  if (searchQuery.value.trim()) {
    // Implement search functionality
    console.log('Searching for:', searchQuery.value)
    // Navigate to search results page or filter current page
    closeMenu()
  }
}

const handleScroll = () => {
  const currentScrollY = window.scrollY

  // Add scrolled class
  scrolled.value = currentScrollY > 50

  // Hide/show header based on scroll direction
  if (currentScrollY > lastScrollY.value && currentScrollY > 200) {
    isHeaderHidden.value = true
  } else {
    isHeaderHidden.value = false
  }

  lastScrollY.value = currentScrollY
}

// Fetch pages for footer
const fetchPages = async () => {
  try {
    console.log('Fetching pages from API...')
    const response = await pageService.getPages()
    console.log('Pages response:', response)

    if (response && response.success && response.data) {
      pagesData.value = response.data
      console.log('Pages loaded successfully:', pagesData.value)
    } else {
      console.warn('No pages found or invalid response')
      pagesData.value = []
    }
  } catch (error) {
    console.error('Failed to fetch pages:', error)
    pagesData.value = []
  }
}

// Fetch footer data
const fetchFooterData = async () => {
  try {
    console.log('Fetching footer data from API...')
    const response = await footerService.getFooterData()
    console.log('Footer data response:', response)

    if (response && response.success && response.data) {
      footerData.value = response.data
      console.log('Footer data loaded successfully:', footerData.value)
    } else {
      console.warn('No footer data found or invalid response')
      footerData.value = null
    }
  } catch (error) {
    console.error('Failed to fetch footer data:', error)
    footerData.value = null
  }
}

// Lifecycle
onMounted(() => {
  // Initial screen size detection
  updateNavigationForScreenSize()

  // Fetch data for footer
  fetchPages()
  fetchFooterData()

  window.addEventListener('scroll', handleScroll, { passive: true })
  window.addEventListener('resize', updateNavigationForScreenSize)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  window.removeEventListener('resize', updateNavigationForScreenSize)
})
</script>

<template>
  <div class="min-h-screen bg-industrial-dark text-slate-100">
    <!-- Top Bar -->
    <div
      class="hidden xl:block bg-industrial-dark border-b border-white/10 py-2 transition-transform duration-300"
      :class="scrolled ? 'opacity-0 -translate-y-full' : 'opacity-100 translate-y-0'"
    >
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between">
          <!-- Contact Info -->
          <div class="flex items-center gap-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">
            <a :href="`tel:${contactInfo.phone}`" class="flex items-center gap-2 hover:text-industrial-blue transition-colors">
              <Phone class="w-3 h-3" />
              {{ contactInfo.phone }}
            </a>
            <a :href="`mailto:${contactInfo.email}`" class="flex items-center gap-2 hover:text-industrial-blue transition-colors">
              <Mail class="w-3 h-3" />
              {{ contactInfo.email }}
            </a>
            <span class="flex items-center gap-2">
              <Globe class="w-3 h-3" />
              {{ contactInfo.address }}
            </span>
          </div>

          <!-- Quick Links & CTA -->
          <div class="flex items-center gap-4">
            <!-- Prominent Get Quote Button -->
            <a
              href="/contact?type=quote"
              class="flex items-center gap-2 bg-industrial-blue hover:bg-industrial-red text-white px-5 py-2 rounded-sm font-black uppercase tracking-wider text-[10px] transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 active:scale-95"
            >
              <Briefcase class="w-3.5 h-3.5" />
              Get a Quote
              <ArrowRight class="w-3.5 h-3.5" />
            </a>

            <!-- Secondary Links -->
            <a href="/contact?type=career" class="hidden sm:flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">
              <Users class="w-3.5 h-3.5" />
              Careers
            </a>

            <!-- Language Selector -->
            <div class="relative group">
              <button class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">
                <Globe class="w-3 h-3" />
                {{ languages.find(l => l.code === currentLanguage)?.name }}
                <ChevronDown class="w-3 h-3" />
              </button>
              <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                <button
                  v-for="lang in languages"
                  :key="lang.code"
                  @click="currentLanguage = lang.code"
                  class="w-full px-4 py-2 text-left text-xs font-bold text-industrial-dark hover:bg-industrial-light transition-colors first:rounded-t-lg last:rounded-b-lg"
                >
                  {{ lang.name }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <header
      class="fixed w-full z-50 transition-all duration-300"
      :class="[
        scrolled ? 'bg-white/98 backdrop-blur-md shadow-xl py-2' : 'bg-transparent py-4',
        isHeaderHidden ? '-translate-y-full' : 'translate-y-0'
      ]"
    >
      <div class="max-w-7xl mx-auto px-4 xl:px-6">
        <div class="flex items-center justify-between gap-4">
          <!-- Logo -->
          <div
            class="flex items-center gap-2 group cursor-pointer flex-shrink-0"
            @click="navigateTo('/')"
          >
            <img
              :src="scrolled ? logoBlack : logoWhite"
              alt="INFLUX GROUP"
              class="h-10 lg:h-12 w-auto object-contain"
            />
          </div>

          <!-- Mobile Menu Button (Left Side) -->
          <button
            class="lg:hidden w-9 h-9 lg:w-10 lg:h-10 flex items-center justify-center rounded-sm transition-colors ml-2"
            :class="scrolled ? 'bg-industrial-light text-industrial-dark' : 'bg-white/10 text-white'"
            @click="toggleMenu"
          >
            <Menu v-if="!isMenuOpen" class="w-5 h-5" />
            <X v-else class="w-5 h-5" />
          </button>

          <!-- Desktop Navigation -->
          <nav class="hidden lg:flex items-center gap-0.5 flex-1 justify-end">
            <div
              v-for="item in currentNavigation"
              :key="item.path || item.name"
              class="relative"
              @mouseenter="item.hasDropdown ? toggleDropdown(item.name) : null"
              @mouseleave="closeDropdown"
            >
              <button
                @click="!item.hasDropdown && navigateTo(item.path)"
                class="flex items-center gap-1 px-2 xl:px-3 py-2 rounded-sm font-bold uppercase tracking-wider text-[9px] xl:text-[10px] transition-all duration-200 whitespace-nowrap"
                :class="[
                  scrolled ? 'text-industrial-dark hover:text-industrial-blue hover:bg-industrial-light' : 'text-white hover:text-industrial-blue hover:bg-white/10',
                  currentPath === item.path ? (scrolled ? 'text-industrial-blue bg-industrial-light' : 'text-industrial-blue bg-white/10') : '',
                  item.highlight ? (scrolled ? 'bg-industrial-blue text-white hover:bg-industrial-red' : 'bg-industrial-blue text-white hover:bg-industrial-red') : ''
                ]"
              >
                <component v-if="item.icon && !isLaptopScreen" :is="item.icon" class="w-3.5 h-3.5 xl:w-4 xl:h-4" />
                {{ item.name }}
                <ChevronDown
                  v-if="item.hasDropdown"
                  class="w-2.5 h-2.5 xl:w-3 xl:h-3 transition-transform duration-200"
                  :class="activeDropdown === item.name ? 'rotate-180' : ''"
                />
              </button>

              <!-- Dropdown Menu -->
              <Transition
                enter-active-class="transition-all duration-200"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition-all duration-150"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
              >
                <div
                  v-if="item.hasDropdown && activeDropdown === item.name"
                  class="absolute top-full left-0 mt-2 w-56 xl:w-64 bg-white rounded-lg shadow-2xl border border-slate-200 py-1.5 xl:py-2 z-50"
                  :class="isLaptopScreen ? 'left-1/2 -translate-x-1/2' : 'left-0'"
                >
                  <a
                    v-for="(dropdownItem, index) in item.dropdownItems"
                    :key="index"
                    @click="navigateTo(dropdownItem.path)"
                    class="block px-3 xl:px-4 py-2 xl:py-3 transition-colors cursor-pointer"
                    :class="dropdownItem.highlight ? 'bg-industrial-blue text-white' : 'hover:bg-industrial-light text-industrial-dark'"
                  >
                    <div class="flex items-start justify-between gap-2 xl:gap-3">
                      <div class="flex-1 min-w-0">
                        <div class="text-[10px] xl:text-xs font-bold uppercase tracking-wider mb-0.5 xl:mb-1 truncate" :class="dropdownItem.highlight ? 'text-white' : 'text-industrial-dark'">
                          {{ dropdownItem.name }}
                        </div>
                        <div
                          v-if="dropdownItem.description && !isLaptopScreen"
                          class="hidden xl:block text-[10px] font-normal leading-relaxed"
                          :class="dropdownItem.highlight ? 'text-industrial-100' : 'text-slate-500'"
                        >
                          {{ dropdownItem.description }}
                        </div>
                      </div>
                      <ChevronRight
                        v-if="!isLaptopScreen"
                        class="w-3.5 h-3.5 xl:w-4 xl:h-4 flex-shrink-0 mt-0.5 xl:mt-1"
                        :class="dropdownItem.highlight ? 'text-white' : 'text-industrial-blue'"
                      />
                    </div>
                  </a>
                </div>
              </Transition>
            </div>
          </nav>
        </div>
      </div>
    </header>

    <!-- Search Overlay -->
    <Transition
      enter-active-class="transition-all duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-all duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isSearchOpen"
        class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm"
        @click="toggleSearch"
      >
        <div class="max-w-3xl mx-auto pt-32 px-6" @click.stop>
          <div class="bg-white rounded-lg shadow-2xl p-6">
            <div class="flex items-center gap-4 mb-6">
              <Search class="w-6 h-6 text-industrial-blue" />
              <input
                id="search-input"
                v-model="searchQuery"
                @keyup.enter="performSearch"
                type="text"
                placeholder="Search products, projects, services..."
                class="flex-1 text-lg font-medium outline-none"
              />
              <button
                @click="toggleSearch"
                class="w-10 h-10 flex items-center justify-center bg-slate-100 rounded-full hover:bg-slate-200 transition-colors"
              >
                <X class="w-5 h-5" />
              </button>
            </div>
            <div class="flex flex-wrap gap-2">
              <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Quick searches:</span>
              <button @click="searchQuery = 'transformer'; performSearch()" class="px-3 py-1 bg-industrial-light text-industrial-dark text-xs font-bold rounded-full hover:bg-industrial-blue hover:text-white transition-colors">
                Transformers
              </button>
              <button @click="searchQuery = 'solar'; performSearch()" class="px-3 py-1 bg-industrial-light text-industrial-dark text-xs font-bold rounded-full hover:bg-industrial-blue hover:text-white transition-colors">
                Solar Power
              </button>
              <button @click="searchQuery = 'EPC'; performSearch()" class="px-3 py-1 bg-industrial-light text-industrial-dark text-xs font-bold rounded-full hover:bg-industrial-blue hover:text-white transition-colors">
                EPC Solutions
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Mobile Menu -->
    <Transition
      enter-active-class="transition-all duration-300"
      enter-from-class="opacity-0 translate-x-full"
      enter-to-class="opacity-100 translate-x-0"
      leave-active-class="transition-all duration-300"
      leave-from-class="opacity-100 translate-x-0"
      leave-to-class="opacity-0 translate-x-full"
    >
      <div
        v-if="isMenuOpen"
        class="fixed inset-0 z-40 lg:hidden bg-industrial-dark/98 backdrop-blur-xl overflow-y-auto"
      >
        <div class="flex flex-col min-h-full pt-24 pb-8 px-6">
          <!-- Search Bar -->
          <div class="mb-6">
            <div class="relative">
              <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
              <input
                v-model="searchQuery"
                @keyup.enter="performSearch"
                type="text"
                placeholder="Search..."
                class="w-full pl-12 pr-4 py-3 bg-white/10 border border-white/20 rounded-sm text-white placeholder-slate-400 focus:outline-none focus:border-industrial-blue transition-colors"
              />
            </div>
          </div>

          <!-- Navigation -->
          <nav class="flex-1">
            <div class="space-y-2">
              <div
                v-for="item in currentNavigation"
                :key="item.path"
                class="border-b border-white/10"
              >
                <button
                  @click="item.hasDropdown ? toggleDropdown(item.name) : navigateTo(item.path)"
                  class="w-full flex items-center justify-between py-4 text-left"
                >
                  <span class="flex items-center gap-3 text-xl font-display font-black uppercase italic transition-colors"
                    :class="currentPath === item.path ? 'text-industrial-blue' : 'text-white'"
                  >
                    <component v-if="item.icon" :is="item.icon" class="w-5 h-5" />
                    {{ item.name }}
                  </span>
                  <ChevronDown
                    v-if="item.hasDropdown"
                    class="w-5 h-5 transition-transform duration-200 text-slate-400"
                    :class="activeDropdown === item.name ? 'rotate-180' : ''"
                  />
                </button>

                <!-- Mobile Dropdown -->
                <Transition
                  enter-active-class="transition-all duration-200"
                  enter-from-class="opacity-0 -translate-y-2"
                  enter-to-class="opacity-100 translate-y-0"
                  leave-active-class="transition-all duration-150"
                  leave-from-class="opacity-100 translate-y-0"
                  leave-to-class="opacity-0 -translate-y-2"
                >
                  <div
                    v-if="item.hasDropdown && activeDropdown === item.name"
                    class="pl-8 pb-4 space-y-2"
                  >
                    <a
                      v-for="(dropdownItem, index) in item.dropdownItems"
                      :key="index"
                      @click="navigateTo(dropdownItem.path)"
                      class="block py-2 text-sm font-medium transition-colors cursor-pointer"
                      :class="dropdownItem.highlight ? 'text-industrial-blue' : 'text-slate-300 hover:text-white'"
                    >
                      {{ dropdownItem.name }}
                    </a>
                  </div>
                </Transition>
              </div>
            </div>
          </nav>

          <!-- Quick Actions -->
          <div class="mt-8 space-y-3">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-500 mb-4">Quick Actions</h3>

            <!-- Featured Get Quote Button -->
            <a
              @click="navigateTo('/contact?type=quote')"
              class="flex items-center justify-center gap-3 p-4 rounded-sm transition-all cursor-pointer bg-industrial-blue text-white hover:bg-industrial-red shadow-xl hover:shadow-2xl hover:scale-105 active:scale-95 border-2 border-industrial-blue"
            >
              <Briefcase class="w-6 h-6" />
              <div class="text-left">
                <div class="font-black uppercase text-sm tracking-wider">Get a Free Quote</div>
                <div class="text-[10px] font-normal text-industrial-100">Response within 24 hours</div>
              </div>
              <ArrowRight class="w-5 h-5 ml-auto" />
            </a>

            <!-- Secondary Actions -->
            <a
              @click="navigateTo('/contact?type=career')"
              class="flex items-center gap-3 p-3 rounded-sm transition-colors cursor-pointer bg-white/10 text-white hover:bg-white/20"
            >
              <Users class="w-5 h-5" />
              <span class="font-bold uppercase text-xs tracking-wider">Careers</span>
            </a>

            <a
              @click="navigateTo('/contact?type=support')"
              class="flex items-center gap-3 p-3 rounded-sm transition-colors cursor-pointer bg-white/10 text-white hover:bg-white/20"
            >
              <Settings class="w-5 h-5" />
              <span class="font-bold uppercase text-xs tracking-wider">Support</span>
            </a>
          </div>

          <!-- Contact Info -->
          <div class="mt-8 p-4 bg-white/5 rounded-sm">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-500 mb-3">Contact Us</h3>
            <div class="space-y-2 text-sm">
              <a :href="`tel:${contactInfo.phone}`" class="flex items-center gap-2 text-white hover:text-industrial-blue transition-colors">
                <Phone class="w-4 h-4" />
                {{ contactInfo.phone }}
              </a>
              <a :href="`mailto:${contactInfo.email}`" class="flex items-center gap-2 text-white hover:text-industrial-blue transition-colors">
                <Mail class="w-4 h-4" />
                {{ contactInfo.email }}
              </a>
              <div class="flex items-center gap-2 text-slate-400">
                <Globe class="w-4 h-4" />
                {{ contactInfo.address }}
              </div>
            </div>
          </div>

          <!-- Language Selector -->
          <div class="mt-6">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-500 mb-3">Language</h3>
            <div class="flex gap-2">
              <button
                v-for="lang in languages"
                :key="lang.code"
                @click="currentLanguage = lang.code"
                class="px-4 py-2 text-xs font-bold uppercase rounded-sm transition-colors"
                :class="currentLanguage === lang.code ? 'bg-industrial-blue text-white' : 'bg-white/10 text-white hover:bg-white/20'"
              >
                {{ lang.name }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Breadcrumb (visible on inner pages) -->
    <Transition
      enter-active-class="transition-all duration-300"
      enter-from-class="opacity-0 -translate-y-4"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition-all duration-200"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-4"
    >
      <div
        v-if="currentPath !== '/' && scrolled"
        class="fixed top-[52px] lg:top-[60px] left-0 right-0 z-40 bg-white/95 backdrop-blur-sm border-b border-slate-200 py-1.5 xl:py-2"
      >
        <div class="max-w-7xl mx-auto px-4 xl:px-6">
          <nav class="flex items-center gap-2 text-[10px] xl:text-xs font-bold uppercase tracking-wider">
            <a @click="navigateTo('/')" class="text-industrial-blue hover:underline cursor-pointer">
              Home
            </a>
            <ChevronRight class="w-3 h-3 text-slate-400" />
            <span class="text-slate-600">{{ routeNameMap[currentPath] || currentNavigation.find(n => n.path === currentPath)?.name || 'Page' }}</span>
          </nav>
        </div>
      </div>
    </Transition>

    <!-- Main Content Area -->
    <main :class="scrolled && currentPath !== '/' ? 'pt-24 lg:pt-28' : 'pt-16 lg:pt-20'">
      <slot />
    </main>

    <!-- Floating Quote Button -->
    <FloatingQuoteButton />

    <!-- Footer -->
    <footer class="bg-industrial-dark text-white border-t border-industrial-blue/20">
      <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 border-b border-white/10 pb-16 mb-12">
          <!-- Company Info -->
          <div class="lg:col-span-1">
            <div class="mb-6">
              <img
                v-if="!footerData?.company_info?.logo"
                :src="logoWhite"
                alt="INFLUX GROUP"
                class="h-10 w-auto object-contain"
              />
              <img
                v-else
                :src="footerData?.company_info?.logo || logoWhite"
                alt="INFLUX GROUP"
                class="h-10 w-auto object-contain"
              />
            </div>
            <p class="text-xs text-slate-400 font-medium leading-relaxed mb-6">
              {{ footerData?.company_info?.description || 'Bangladesh\'s premier engineering conglomerate specializing in high-voltage infrastructure and renewable grid systems since 1980.' }}
            </p>
            <!-- Social Media Links -->
            <div class="flex gap-4">
              <template v-if="footerData?.social_media && footerData.social_media.length > 0">
                <a
                  v-for="(social, index) in footerData.social_media"
                  :key="index"
                  :href="social.url"
                  class="w-10 h-10 flex items-center justify-center bg-white/10 rounded-lg hover:bg-industrial-blue transition-colors group"
                  :aria-label="social.platform"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path v-if="social.platform === 'facebook'" d="M18.77,7.46H14.5v-1.9c0-.9.6-1.1,1-1.1h3V.5h-3c-2.2,0-3.9,1.4-3.9,4v2.1H7v3.2h3.6v8.5h3.2V11h3.3l.5-3.2H13.7V9.6c0-.3.1-.9.4-.9h2.4l0.3-1.2Z"/>
                    <path v-else-if="social.platform === 'linkedin'" d="M20.45,20.45h-3.56v-5.6c0-1.34,0-3.07-1.88-3.07-1.88,0-2.17,1.45-2.17,2.95v5.72H9.28V9h3.42v1.52h.05c.48-.9,1.67-1.85,3.44-1.85,3.68,0,4.35,2.42,4.35,5.57v5.21h0ZM5.34,7.43c-1.13,0-2.05-.92-2.05-2.05s.92-2.05,2.05-2.05,2.05,.92,2.05,2.05-.92,2.05-2.05,2.05ZM7.11,20.45H3.57V9h3.54V20.45h0ZM22.22,0H1.77C.79,0,0,.77,0,1.73v20.54C0,23.23,.79,24,1.77,24h20.45c.98,0,1.77-.77,1.77-1.73V1.73c0-.96-.79-1.73-1.77-1.73Z"/>
                    <path v-else-if="social.platform === 'youtube'" d="M23.5,6.14c-.27-1.01-.98-1.82-1.99-2.08C17.87,3.31,12,3.31,12,3.31s-5.87,0-7.51,.75c-1.01,.27-1.82,.98-2.08,1.99C1.5,8.45,1.5,12,1.5,12c0,3.55,.91,7.01,1.91,7.86,.27,1.01,.98,1.82,1.99,2.08,1.64,.75,7.51,.75,7.51,.75s5.87,0,7.51-.75c1.01-.27,1.82-.98,2.08-1.99,.91-1.12,1.91-4.58,1.91-7.86,0-3.55-.91-7.01-1.91-7.86ZM9.75,15.64V8.36l6.33,3.64-6.33,3.64Z"/>
                    <path v-else d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6z"/>
                  </svg>
                </a>
              </template>
              <template v-else>
                <a href="#" class="w-10 h-10 flex items-center justify-center bg-white/10 rounded-lg hover:bg-industrial-blue transition-colors group" aria-label="Facebook">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.77,7.46H14.5v-1.9c0-.9.6-1.1,1-1.1h3V.5h-3c-2.2,0-3.9,1.4-3.9,4v2.1H7v3.2h3.6v8.5h3.2V11h3.3l.5-3.2H13.7V9.6c0-.3.1-.9.4-.9h2.4l0.3-1.2Z"/>
                  </svg>
                </a>
                <a href="#" class="w-10 h-10 flex items-center justify-center bg-white/10 rounded-lg hover:bg-industrial-blue transition-colors group" aria-label="LinkedIn">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.45,20.45h-3.56v-5.6c0-1.34,0-3.07-1.88-3.07-1.88,0-2.17,1.45-2.17,2.95v5.72H9.28V9h3.42v1.52h.05c.48-.9,1.67-1.85,3.44-1.85,3.68,0,4.35,2.42,4.35,5.57v5.21h0ZM5.34,7.43c-1.13,0-2.05-.92-2.05-2.05s.92-2.05,2.05-2.05,2.05,.92,2.05,2.05-.92,2.05-2.05,2.05ZM7.11,20.45H3.57V9h3.54V20.45h0ZM22.22,0H1.77C.79,0,0,.77,0,1.73v20.54C0,23.23,.79,24,1.77,24h20.45c.98,0,1.77-.77,1.77-1.73V1.73c0-.96-.79-1.73-1.77-1.73Z"/>
                  </svg>
                </a>
                <a href="#" class="w-10 h-10 flex items-center justify-center bg-white/10 rounded-lg hover:bg-industrial-blue transition-colors group" aria-label="YouTube">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.5,6.14c-.27-1.01-.98-1.82-1.99-2.08C17.87,3.31,12,3.31,12,3.31s-5.87,0-7.51,.75c-1.01,.27-1.82,.98-2.08,1.99C1.5,8.45,1.5,12,1.5,12c0,3.55,.91,7.01,1.91,7.86,.27,1.01,.98,1.82,1.99,2.08,1.64,.75,7.51,.75,7.51,.75s5.87,0,7.51-.75c1.01-.27,1.82-.98,2.08-1.99,.91-1.12,1.91-4.58,1.91-7.86,0-3.55-.91-7.01-1.91-7.86ZM9.75,15.64V8.36l6.33,3.64-6.33,3.64Z"/>
                  </svg>
                </a>
              </template>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="space-y-6">
            <h4 class="text-sm font-bold uppercase tracking-wider text-industrial-blue">Quick Links</h4>
            <ul class="space-y-3 text-xs font-medium text-slate-300">
              <li><a @click="navigateTo('/')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> Home</a></li>
              <li><a @click="navigateTo('/about')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> About Us</a></li>
              <li><a @click="navigateTo('/projects')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> Projects</a></li>
              <li><a @click="navigateTo('/products')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> Products</a></li>
              <li><a @click="navigateTo('/contact')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> Contact Us</a></li>
            </ul>
          </div>

          <!-- Services -->
          <div class="space-y-6">
            <h4 class="text-sm font-bold uppercase tracking-wider text-industrial-blue">Our Services</h4>
            <ul v-if="pagesData && pagesData.length > 0" class="space-y-3 text-xs font-medium text-slate-300">
              <li v-for="page in pagesData.slice(0, 5)" :key="page.id">
                <a
                  @click="navigateTo(`/pages/${page.slug}`)"
                  class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"
                >
                  <ChevronRight class="w-3.5 h-3.5" />
                  {{ page.title }}
                </a>
              </li>
            </ul>
            <ul v-else class="space-y-3 text-xs font-medium text-slate-300">
              <li><a @click="navigateTo('/services-and-solutions')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> EPC Solutions</a></li>
              <li><a @click="navigateTo('/services-and-solutions')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> MEP Services</a></li>
              <li><a @click="navigateTo('/services-and-solutions')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> Maintenance Services</a></li>
              <li><a @click="navigateTo('/services-and-solutions')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> Engineering Solutions</a></li>
              <li><a @click="navigateTo('/news')" class="hover:text-white transition-colors cursor-pointer flex items-center gap-2"><ChevronRight class="w-3.5 h-3.5" /> News & Updates</a></li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div class="space-y-6">
            <h4 class="text-sm font-bold uppercase tracking-wider text-industrial-blue">Get In Touch</h4>
            <ul class="space-y-4 text-xs font-medium text-slate-300">
              <li class="flex items-start gap-3">
                <Phone class="w-4 h-4 mt-0.5 text-industrial-blue flex-shrink-0" />
                <div>
                  <a :href="`tel:${contactInfo.phone}`" class="hover:text-white transition-colors">{{ contactInfo.phone }}</a>
                  <p class="text-slate-500 text-[10px] mt-1">Mon-Sat 9AM-6PM</p>
                </div>
              </li>
              <li class="flex items-start gap-3">
                <Mail class="w-4 h-4 mt-0.5 text-industrial-blue flex-shrink-0" />
                <a :href="`mailto:${contactInfo.email}`" class="hover:text-white transition-colors">{{ contactInfo.email }}</a>
              </li>
              <li class="flex items-start gap-3">
                <Globe class="w-4 h-4 mt-0.5 text-industrial-blue flex-shrink-0" />
                <span>{{ contactInfo.address }}</span>
              </li>
            </ul>

          </div>
        </div>

        <!-- Bottom Bar -->
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6 pt-8 border-t border-white/10">
          <div class="text-[10px] font-medium text-slate-500 text-center lg:text-left">
            {{ footerData?.bottom_bar?.copyright_text || '© 2026 INFLUX GROUP ENGINEERING. All Rights Reserved.' }}
          </div>
          <div v-if="footerData?.bottom_bar?.show_iso_badge !== false" class="flex items-center gap-2 text-[10px] font-medium text-slate-500">
            <span class="text-slate-400">{{ footerData?.bottom_bar?.iso_certification || 'ISO 9001:2015' }}</span>
            <ShieldCheck class="w-4 h-4 text-green-500" />
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<style>
/* Custom scrollbar for mobile menu */
@media (max-width: 1024px) {
  .overflow-y-auto::-webkit-scrollbar {
    width: 4px;
  }

  .overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
  }

  .overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(0, 98, 255, 0.5);
    border-radius: 10px;
  }

  .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 98, 255, 0.8);
  }
}
</style>

<style>
/* Custom scrollbar for mobile menu */
@media (max-width: 1024px) {
  .overflow-y-auto::-webkit-scrollbar {
    width: 4px;
  }

  .overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
  }

  .overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(0, 98, 255, 0.5);
    border-radius: 10px;
  }

  .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 98, 255, 0.8);
  }
}
</style>
