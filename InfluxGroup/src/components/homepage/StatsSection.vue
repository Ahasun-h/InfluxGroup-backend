<template>
  <section class="py-16 md:py-20 bg-gray-50 dark:bg-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        <div
          v-for="(stat, key) in stats"
          :key="key"
          class="text-center p-6 bg-white dark:bg-surface-700 rounded-2xl shadow-lg hover:shadow-xl transition-all"
        >
          <div class="text-4xl md:text-5xl font-extrabold text-brand-600 mb-2">
            {{ formatNumber(stat) }}
          </div>
          <div class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
            {{ formatLabel(key) }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  stats: {
    type: Object,
    required: true
  }
})

const formatNumber = (num) => {
  if (num >= 1000) {
    return (num / 1000).toFixed(0) + 'K+'
  }
  return num.toString()
}

const formatLabel = (key) => {
  return key.replace(/_/g, ' ')
}
</script>