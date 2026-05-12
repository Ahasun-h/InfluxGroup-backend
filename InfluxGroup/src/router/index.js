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
    path: '/projects',
    name: 'Projects',
    component: () => import('../pages/Projects.vue'),
    meta: {
      title: 'Projects | Influx Group',
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
    path: '/solutions',
    name: 'Solutions',
    component: () => import('../pages/Solutions.vue'),
    meta: {
      title: 'Solutions | Influx Group',
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
  document.title = to.meta.title || 'Influx Group'
  next()
})

export default router
