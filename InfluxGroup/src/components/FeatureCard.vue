<script setup>
import { computed } from 'vue'

const props = defineProps({
  icon: {
    type: [Object, Function],
    required: true
  },
  title: {
    type: String,
    required: true
  },
  description: {
    type: String,
    required: true
  },
  variant: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'glass', 'bordered'].includes(value)
  },
  size: {
    type: String,
    default: 'medium',
    validator: (value) => ['small', 'medium', 'large'].includes(value)
  }
})

const cardClasses = computed(() => {
  const variants = {
    default: 'bg-white',
    glass: 'glass-panel',
    bordered: 'bg-white border-2 border-slate-200'
  }

  const sizes = {
    small: 'p-4',
    medium: 'p-6',
    large: 'p-8'
  }

  return [
    'rounded-lg hover:shadow-2xl transition-all duration-500 group',
    variants[props.variant],
    sizes[props.size]
  ].join(' ')
})
</script>

<template>
  <div :class="cardClasses">
    <div class="flex items-start gap-4">
      <div
        :class="[
          'w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform',
          variant === 'glass' ? 'bg-industrial-blue' : 'bg-industrial-blue'
        ]"
      >
        <component :is="icon" class="w-6 h-6 text-white" />
      </div>
      <div class="flex-1">
        <h3
          :class="[
            'font-bold mb-2 group-hover:text-industrial-blue transition-colors',
            size === 'large' ? 'text-xl' : 'text-lg'
          ]"
        >
          {{ title }}
        </h3>
        <p class="text-slate-600 text-sm leading-relaxed">
          {{ description }}
        </p>
        <slot />
      </div>
    </div>
  </div>
</template>
