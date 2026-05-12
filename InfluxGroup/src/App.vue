<script setup>
import MainLayout from './layouts/MainLayout.vue'
import { onMounted } from 'vue'

onMounted(() => {
  // Add smooth scroll behavior
  document.documentElement.style.scrollBehavior = 'smooth'

  // Add page transition classes
  document.body.classList.add('page-transitions-enabled')
})
</script>

<template>
  <MainLayout>
    <router-view v-slot="{ Component, route }">
      <Transition
        :name="route.meta.transition || 'fade'"
        mode="out-in"
        @before-enter="() => document.body.classList.add('page-transitioning')"
        @after-enter="() => document.body.classList.remove('page-transitioning')"
        @before-leave="() => document.body.classList.add('page-transitioning')"
        @after-leave="() => document.body.classList.remove('page-transitioning')"
      >
        <component :is="Component" :key="route.path" />
      </Transition>
    </router-view>
  </MainLayout>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Outfit:wght@700;800;900&display=swap');

/* Page Transition Styles */
.page-transitions-enabled {
  overflow-x: hidden;
}

.page-transitioning {
  overflow: hidden;
}

/* Fade Transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Slide Transition */
.slide-enter-active,
.slide-leave-active {
  transition: all 0.5s ease;
}

.slide-enter-from {
  opacity: 0;
  transform: translateY(30px);
}

.slide-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}

/* Scale Transition */
.scale-enter-active,
.scale-leave-active {
  transition: all 0.5s ease;
}

.scale-enter-from,
.scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

/* Slide Left Transition */
.slide-left-enter-active,
.slide-left-leave-active {
  transition: all 0.5s ease;
}

.slide-left-enter-from {
  opacity: 0;
  transform: translateX(-30px);
}

.slide-left-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

/* Scroll Animation Classes */
.scroll-animate {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.6s ease-out;
}

.scroll-animate.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Staggered Animation Delays */
.stagger-1 { transition-delay: 0.1s; }
.stagger-2 { transition-delay: 0.2s; }
.stagger-3 { transition-delay: 0.3s; }
.stagger-4 { transition-delay: 0.4s; }
.stagger-5 { transition-delay: 0.5s; }
</style>
