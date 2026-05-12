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

const router = useRouter()
const route = useRoute()
const isMenuOpen = ref(false)
const scrolled = ref(false)
const activeDropdown = ref(null)
const isSearchOpen = ref(false)
const searchQuery = ref('')
const lastScrollY = ref(0)
const isHeaderHidden = ref(false)

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
    name: 'Services',
    path: '/services',
    hasDropdown: true,
    dropdownItems: [
      { name: 'EPC Solutions', path: '/solutions#epc', description: 'Turnkey project delivery' },
      { name: 'MEP Services', path: '/solutions#mep', description: 'Mechanical, Electrical & Plumbing' },
      { name: 'Maintenance', path: '/services#maintenance', description: '24/7 support services' },
      { name: 'Testing & Commissioning', path: '/services#testing', description: 'Complete testing services' },
      { name: 'Training', path: '/services#training', description: 'Technical training programs' }
    ]
  },
  {
    name: 'Solutions',
    path: '/solutions',
    hasDropdown: true,
    dropdownItems: [
      { name: 'Power Sector', path: '/solutions#power', description: 'Generation & distribution' },
      { name: 'Industrial', path: '/solutions#industrial', description: 'Manufacturing & factory' },
      { name: 'Commercial', path: '/solutions#commercial', description: 'Office & retail' },
      { name: 'Renewable Energy', path: '/solutions#renewable', description: 'Solar & wind power' }
    ]
  },
  {
    name: 'Resources',
    path: '/news',
    icon: FileText,
    hasDropdown: true,
    dropdownItems: [
      { name: 'News & Updates', path: '/news', description: 'Latest company news' },
      { name: 'Gallery', path: '/gallery', description: 'Photos & videos' },
      { name: 'Case Studies', path: '/projects', description: 'Success stories' },
      { name: 'Technical Papers', path: '/news', description: 'Research & development' }
    ]
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
      { name: 'Services', path: '/services' },
      { name: 'Solutions', path: '/solutions' },
      { name: 'News', path: '/news' },
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

// Lifecycle
onMounted(() => {
  // Initial screen size detection
  updateNavigationForScreenSize()

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
            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-industrial-blue flex items-center justify-center rounded-sm transform group-hover:bg-industrial-red transition-all duration-500 shadow-lg">
              <Zap class="text-white w-5 h-5 lg:w-6 lg:h-6" />
            </div>
            <div class="flex flex-col leading-none">
              <span class="text-lg xl:text-xl font-display font-black tracking-tighter uppercase italic" :class="scrolled ? 'text-industrial-dark' : 'text-white'">
                INFLUX<span class="text-industrial-blue">GROUP</span>
              </span>
              <span class="hidden sm:block text-[8px] font-bold uppercase tracking-[0.3em]" :class="scrolled ? 'text-slate-500' : 'text-slate-400'">Engineering the future</span>
            </div>
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
          <nav class="hidden lg:flex items-center gap-0.5 flex-1 justify-center">
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
            <span class="text-slate-600">{{ currentNavigation.find(n => n.path === currentPath)?.name || 'Page' }}</span>
          </nav>
        </div>
      </div>
    </Transition>

    <!-- Main Content -->
    <main :class="scrolled && currentPath !== '/' ? 'pt-24 lg:pt-28' : 'pt-16 lg:pt-20'">
      <router-view v-slot="{ Component }">
        <Transition
          mode="out-in"
          enter-active-class="transition-all duration-500"
          enter-from-class="opacity-0 translate-y-8"
          enter-to-class="opacity-100 translate-y-0"
          leave-active-class="transition-all duration-300"
          leave-from-class="opacity-100 translate-y-0"
          leave-to-class="opacity-0 -translate-y-8"
        >
          <component :is="Component" />
        </Transition>
      </router-view>
    </main>

    <!-- Floating Quote Button -->
    <FloatingQuoteButton />

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 text-industrial-dark">
      <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-4 gap-12 border-b border-slate-100 pb-16 mb-16">
          <!-- Company Info -->
          <div class="md:col-span-1">
            <div class="flex items-center gap-2 mb-6">
              <Zap class="text-industrial-blue w-6 h-6" />
              <span class="text-xl font-display font-black tracking-tighter uppercase italic">
                INFLUX<span class="text-industrial-blue">GROUP</span>
              </span>
            </div>
            <p class="text-xs text-slate-500 font-medium leading-relaxed">
              Bangladesh's premier engineering conglomerate specializing in high-voltage infrastructure and renewable grid systems.
            </p>
          </div>

          <!-- Quick Links -->
          <div v-for="col in 3" :key="col" class="space-y-6">
            <h4 class="text-xs font-black uppercase tracking-[0.2em] text-industrial-blue">Quick Portal</h4>
            <ul class="space-y-3 text-[11px] font-bold text-slate-400 uppercase">
              <li><a href="#" class="hover:text-industrial-blue transition-colors">Career Opportunities</a></li>
              <li><a href="#" class="hover:text-industrial-blue transition-colors">Investor Relations</a></li>
              <li><a href="#" class="hover:text-industrial-blue transition-colors">Technical Library</a></li>
              <li><a href="#" class="hover:text-industrial-blue transition-colors">Support Hub</a></li>
            </ul>
          </div>
        </div>

        <!-- Bottom Bar -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
          <div class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-400">
            © 2026 INFLUX GROUP ENGINEERING. ALL RIGHTS RESERVED. ISO 9001:2015 CERTIFIED.
          </div>
          <div class="flex gap-8 text-[9px] font-black uppercase tracking-[0.3em]">
            <a href="#" class="text-slate-400 hover:text-industrial-blue transition-colors">Privacy Protocol</a>
            <a href="#" class="text-slate-400 hover:text-industrial-blue transition-colors">Cyber Security</a>
            <a href="#" class="text-slate-400 hover:text-industrial-blue transition-colors">LinkedIn</a>
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
