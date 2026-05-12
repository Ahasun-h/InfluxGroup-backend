<script setup>
import { computed } from 'vue'
import { Linkedin, Mail, Phone } from 'lucide-vue-next'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  role: {
    type: String,
    required: true
  },
  expertise: {
    type: String,
    default: ''
  },
  image: {
    type: String,
    required: true
  },
  variant: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'compact', 'minimal'].includes(value)
  }
})
</script>

<template>
  <div
    :class="[
      'group bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500',
      variant === 'compact' ? '' : ''
    ]"
  >
    <div class="relative overflow-hidden">
      <img
        :src="image"
        :alt="name"
        :class="[
          'w-full object-cover transition-transform duration-700 group-hover:scale-110',
          variant === 'compact' ? 'h-48' : 'h-64'
        ]"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <div class="absolute bottom-4 left-4 right-4 flex gap-2">
          <a
            v-if="variant !== 'minimal'"
            href="#"
            class="w-10 h-10 bg-industrial-blue rounded-full flex items-center justify-center text-white hover:bg-industrial-red transition-colors"
          >
            <Linkedin class="w-4 h-4" />
          </a>
          <a
            v-if="variant !== 'minimal'"
            href="#"
            class="w-10 h-10 bg-industrial-blue rounded-full flex items-center justify-center text-white hover:bg-industrial-red transition-colors"
          >
            <Mail class="w-4 h-4" />
          </a>
        </div>
      </div>
    </div>

    <div :class="['p-6', variant === 'compact' ? 'p-4' : 'p-6']">
      <h3
        :class="[
          'font-display font-black uppercase italic mb-2 group-hover:text-industrial-blue transition-colors',
          variant === 'compact' ? 'text-lg' : 'text-xl'
        ]"
      >
        {{ name }}
      </h3>
      <p class="text-industrial-blue text-xs font-bold uppercase tracking-wider mb-2">
        {{ role }}
      </p>
      <p v-if="expertise && variant !== 'minimal'" class="text-slate-600 text-sm">
        {{ expertise }}
      </p>
      <slot />
    </div>
  </div>
</template>
