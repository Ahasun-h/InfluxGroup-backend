<script setup>
import { useRouter, useRoute } from 'vue-router'
import { ChevronRight, Home } from 'lucide-vue-next'

const router = useRouter()
const route = useRoute()

const breadcrumbs = computed(() => {
  const paths = route.path.split('/').filter(Boolean)

  return paths.map((path, index) => {
    const fullPath = '/' + paths.slice(0, index + 1).join('/')
    const name = path.charAt(0).toUpperCase() + path.slice(1)

    return {
      name,
      path: fullPath,
      isLast: index === paths.length - 1
    }
  })
})

const navigateTo = (path) => {
  router.push(path)
}
</script>

<template>
  <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider">
    <button
      @click="navigateTo('/')"
      class="flex items-center gap-1 text-industrial-blue hover:underline transition-colors"
    >
      <Home class="w-3 h-3" />
      Home
    </button>

    <template v-for="(crumb, index) in breadcrumbs" :key="crumb.path">
      <ChevronRight class="w-3 h-3 text-slate-400" />
      <button
        v-if="!crumb.isLast"
        @click="navigateTo(crumb.path)"
        class="text-industrial-blue hover:underline transition-colors"
      >
        {{ crumb.name }}
      </button>
      <span v-else class="text-slate-600">{{ crumb.name }}</span>
    </template>
  </nav>
</template>
