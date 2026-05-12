<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'light',
    validator: (value) => ['light', 'dark', 'blue', 'white'].includes(value)
  },
  padding: {
    type: String,
    default: 'large',
    validator: (value) => ['none', 'small', 'medium', 'large', 'xl'].includes(value)
  },
  container: {
    type: Boolean,
    default: true
  }
})

const sectionClasses = computed(() => {
  const variants = {
    light: 'bg-industrial-light text-industrial-dark',
    dark: 'bg-industrial-dark text-white',
    blue: 'bg-industrial-blue text-white',
    white: 'bg-white text-industrial-dark'
  }

  const paddings = {
    none: '',
    small: 'py-12',
    medium: 'py-16',
    large: 'py-20',
    xl: 'py-32'
  }

  return [variants[props.variant], paddings[props.padding]].join(' ')
})
</script>

<template>
  <section :class="sectionClasses">
    <div :class="container ? 'max-w-7xl mx-auto px-6' : ''">
      <slot />
    </div>
  </section>
</template>
