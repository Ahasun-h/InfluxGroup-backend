<script setup>
import { computed } from 'vue'
import { TrendingUp, TrendingDown } from 'lucide-vue-next'

const props = defineProps({
  value: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  trend: {
    type: String,
    default: '',
    validator: (value) => ['', 'up', 'down'].includes(value)
  },
  trendValue: {
    type: String,
    default: ''
  },
  variant: {
    type: String,
    default: 'blue',
    validator: (value) => ['blue', 'red', 'green', 'white'].includes(value)
  }
})

const variantClasses = computed(() => {
  const variants = {
    blue: 'text-industrial-blue',
    red: 'text-industrial-red',
    green: 'text-green-500',
    white: 'text-white'
  }
  return variants[props.variant]
})

const trendIcon = computed(() => {
  return props.trend === 'up' ? TrendingUp : props.trend === 'down' ? TrendingDown : null
})
</script>

<template>
  <div class="text-center group">
    <div
      :class="[
        'text-4xl md:text-5xl font-display font-black mb-2 group-hover:scale-110 transition-transform',
        variantClasses
      ]"
    >
      {{ value }}
    </div>
    <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">
      {{ label }}
    </div>
    <div
      v-if="trend && trendValue"
      :class="[
        'flex items-center justify-center gap-1 text-xs font-bold',
        trend === 'up' ? 'text-green-500' : 'text-red-500'
      ]"
    >
      <component :is="trendIcon" class="w-3 h-3" />
      {{ trendValue }}
    </div>
  </div>
</template>
