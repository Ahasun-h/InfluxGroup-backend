<script setup>
import { computed } from 'vue'
import { ArrowRight, Loader } from 'lucide-vue-next'

const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'outline', 'ghost'].includes(value)
  },
  size: {
    type: String,
    default: 'medium',
    validator: (value) => ['small', 'medium', 'large'].includes(value)
  },
  loading: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  },
  icon: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['click'])

const buttonClasses = computed(() => {
  const variants = {
    primary: 'bg-industrial-blue hover:bg-industrial-red text-white',
    secondary: 'bg-white text-industrial-dark hover:bg-industrial-light',
    outline: 'border-2 border-industrial-blue text-industrial-blue hover:bg-industrial-blue hover:text-white',
    ghost: 'bg-transparent text-industrial-blue hover:bg-industrial-blue/10'
  }

  const sizes = {
    small: 'px-4 py-2 text-xs',
    medium: 'px-8 py-4 text-xs',
    large: 'px-12 py-5 text-sm'
  }

  return [
    'font-black uppercase tracking-widest rounded-sm transition-all duration-300 flex items-center justify-center gap-2',
    variants[props.variant],
    sizes[props.size],
    props.disabled || props.loading ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105 active:scale-95'
  ].join(' ')
})
</script>

<template>
  <button
    :class="buttonClasses"
    :disabled="disabled || loading"
    @click="emit('click')"
  >
    <Loader v-if="loading" class="w-4 h-4 animate-spin" />
    <ArrowRight v-if="icon && !loading" class="w-4 h-4" />
    <slot />
  </button>
</template>
