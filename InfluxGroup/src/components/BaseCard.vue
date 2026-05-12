<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'glass', 'bordered', 'elevated'].includes(value)
  },
  hover: {
    type: Boolean,
    default: false
  },
  padding: {
    type: String,
    default: 'normal',
    validator: (value) => ['none', 'small', 'normal', 'large'].includes(value)
  }
})

const cardClasses = computed(() => {
  const variants = {
    default: 'bg-white',
    glass: 'glass-panel',
    bordered: 'bg-white border-2 border-slate-200',
    elevated: 'bg-white shadow-xl'
  }

  const paddings = {
    none: '',
    small: 'p-4',
    normal: 'p-6',
    large: 'p-8'
  }

  return [
    'rounded-lg overflow-hidden transition-all duration-500',
    variants[props.variant],
    props.hover ? 'hover:shadow-2xl hover:-translate-y-1' : '',
    paddings[props.padding]
  ].join(' ')
})
</script>

<template>
  <div :class="cardClasses">
    <slot />
  </div>
</template>
