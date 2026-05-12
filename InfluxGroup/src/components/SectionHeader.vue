<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  subtitle: {
    type: String,
    default: ''
  },
  alignment: {
    type: String,
    default: 'left',
    validator: (value) => ['left', 'center', 'right'].includes(value)
  },
  variant: {
    type: String,
    default: 'dark',
    validator: (value) => ['light', 'dark', 'blue'].includes(value)
  },
  size: {
    type: String,
    default: 'large',
    validator: (value) => ['medium', 'large', 'xl'].includes(value)
  }
})

const alignmentClasses = computed(() => {
  const alignments = {
    left: 'text-left',
    center: 'text-center',
    right: 'text-right'
  }
  return alignments[props.alignment]
})

const titleColorClass = computed(() => {
  const colors = {
    light: 'text-industrial-dark',
    dark: 'text-white',
    blue: 'text-white'
  }
  return colors[props.variant]
})

const subtitleColorClass = computed(() => {
  const colors = {
    light: 'text-slate-600',
    dark: 'text-slate-300',
    blue: 'text-industrial-100'
  }
  return colors[props.variant]
})

const titleSizeClass = computed(() => {
  const sizes = {
    medium: 'text-3xl md:text-4xl',
    large: 'text-4xl md:text-5xl',
    xl: 'text-5xl md:text-6xl lg:text-7xl'
  }
  return sizes[props.size]
})
</script>

<template>
  <div :class="[alignmentClasses, 'mb-12']">
    <h2
      :class="[
        'font-display font-black uppercase italic leading-[0.9]',
        titleColorClass,
        titleSizeClass
      ]"
    >
      <slot name="title">{{ title }}</slot>
    </h2>
    <p
      v-if="subtitle || $slots.subtitle"
      :class="['mt-4 text-lg max-w-3xl', subtitleColorClass, alignmentClasses === 'text-center' ? 'mx-auto' : '']"
    >
      <slot name="subtitle">{{ subtitle }}</slot>
    </p>
  </div>
</template>
