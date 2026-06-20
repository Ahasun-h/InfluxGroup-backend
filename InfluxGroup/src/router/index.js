import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../pages/Home.vue'),
    meta: {
      title: 'Home | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../pages/About.vue'),
    meta: {
      title: 'About Us | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/products',
    name: 'Products',
    component: () => import('../pages/Products.vue'),
    meta: {
      title: 'Products | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/products/category/:category',
    name: 'ProductCategory',
    component: () => import('../pages/ProductCategory.vue'),
    meta: {
      title: 'Product Category | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/products/:slug',
    name: 'ProductDetail',
    component: () => import('../pages/ProductDetail.vue'),
    meta: {
      title: 'Product Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/projects',
    name: 'Projects',
    component: () => import('../pages/Projects.vue'),
    meta: {
      title: 'Projects | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/projects/:slug',
    name: 'ProjectDetail',
    component: () => import('../pages/ProjectDetail.vue'),
    meta: {
      title: 'Project Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/services',
    name: 'Services',
    component: () => import('../pages/Services.vue'),
    meta: {
      title: 'Services | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/services/:slug',
    name: 'ServiceDetail',
    component: () => import('../pages/ServiceDetail.vue'),
    meta: {
      title: 'Service Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/solutions',
    name: 'Solutions',
    component: () => import('../pages/Solutions.vue'),
    meta: {
      title: 'Solutions | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/solutions/:slug',
    name: 'SolutionDetail',
    component: () => import('../pages/SolutionDetail.vue'),
    meta: {
      title: 'Solution Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/news',
    name: 'News',
    component: () => import('../pages/News.vue'),
    meta: {
      title: 'News | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/news/:slug',
    name: 'NewsDetail',
    component: () => import('../pages/NewsDetail.vue'),
    meta: {
      title: 'News Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('../pages/Contact.vue'),
    meta: {
      title: 'Contact | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/gallery',
    name: 'Gallery',
    component: () => import('../pages/Gallery.vue'),
    meta: {
      title: 'Gallery | Influx Group',
      transition: 'scale'
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0, behavior: 'smooth' }
    }
  }
})

// Update page title
router.beforeEach((to, from, next) => {
  let title = to.meta.title || 'Influx Group'

  // Dynamic title for product category
  if (to.name === 'ProductCategory' && to.params.category) {
    const categoryName = to.params.category
      .split('-')
      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
      .join(' ')
    title = `${categoryName} | Influx Group`
  }

  document.title = title
  next()
})

export default router
