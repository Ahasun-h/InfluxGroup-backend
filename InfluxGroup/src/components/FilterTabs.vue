<script setup>
import { computed } from 'vue'
import { Filter } from 'lucide-vue-next'

const props = defineProps({
  options: {
    type: Array,
    required: true,
    validator: (value) => value.every(opt => opt.id && opt.name)
  },
  modelValue: {
    type: [String, Number],
    required: true
  },
  variant: {
    type: String,
    default: 'pills',
    validator: (value) => ['pills', 'underline', 'buttons'].includes(value)
  },
  alignment: {
    type: String,
    default: 'center',
    validator: (value) => ['left', 'center', 'right'].includes(value)
  }
})

const emit = defineEmits(['update:modelValue'])

const updateValue = (value) => {
  emit('update:modelValue', value)
}

const containerClasses = computed(() => {
  const alignments = {
    left: 'justify-start',
    center: 'justify-center',
    right: 'justify-end'
  }
  return ['flex', 'flex-wrap', 'gap-3', alignments[props.alignment]]
})

const buttonClasses = computed(() => {
  const variants = {
    pills: 'px-6 py-3 rounded-sm font-bold uppercase text-xs tracking-wider transition-all',
    underline: 'px-4 py-2 font-bold uppercase text-xs tracking-wider border-b-2 transition-colors',
    buttons: 'px-8 py-4 rounded-sm font-bold uppercase text-xs tracking-wider transition-all'
  }

  const activeClasses = {
    pills: 'bg-industrial-blue text-white',
    underline: 'border-industrial-blue text-industrial-blue',
    buttons: 'bg-industrial-blue text-white'
  }

  const inactiveClasses = {
    pills: 'bg-industrial-light text-industrial-dark hover:bg-industrial-blue/10',
    underline: 'border-transparent text-slate-500 hover:text-industrial-dark',
    buttons: 'bg-white text-industrial-dark hover:bg-industrial-light border-2 border-slate-200'
  }

  return (isActive) => [
    variants[props.variant],
    isActive ? activeClasses[props.variant] : inactiveClasses[props.variant]
  ].join(' ')
})
</script>

<template>
  <div :class="containerClasses">
    <button
      v-for="option in options"
      :key="option.id"
      :class="buttonClasses(modelValue === option.id)"
      @click="updateValue(option.id)"
    >
      <Filter v-if="variant === 'pills'" class="w-4 h-4 inline mr-2" />
      <component
        :is="option.icon"
        v-if="option.icon && variant !== 'pills'"
        class="w-4 h-4 inline mr-2"
      />
      {{ option.name }}
    </button>
  </div>
</template>
