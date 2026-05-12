<script setup>
import { computed } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    required: true,
    validator: (value) => value.every(item => item.year && item.title && item.description)
  },
  variant: {
    type: String,
    default: 'center',
    validator: (value) => ['center', 'left', 'right'].includes(value)
  }
})

const alignmentClass = computed(() => {
  const alignments = {
    center: 'left-1/2 -translate-x-1/2',
    left: 'left-0',
    right: 'right-0'
  }
  return alignments[props.variant]
})
</script>

<template>
  <div class="relative">
    <!-- Timeline Line -->
    <div
      :class="[
        'absolute top-0 bottom-0 w-1 bg-industrial-blue/20',
        variant === 'center' ? 'left-1/2 -translate-x-1/2' : variant === 'left' ? 'left-8' : 'right-8'
      ]"
    ></div>

    <!-- Timeline Items -->
    <div class="space-y-12">
      <div
        v-for="(item, index) in items"
        :key="index"
        class="relative flex items-center"
        :class="[
          variant === 'center' ? (index % 2 === 0 ? 'flex-row' : 'flex-row-reverse') : '',
          variant === 'left' ? 'flex-row' : '',
          variant === 'right' ? 'flex-row-reverse' : ''
        ]"
      >
        <!-- Dot -->
        <div
          :class="[
            'absolute w-6 h-6 bg-industrial-blue rounded-full border-4 border-white shadow-lg z-10',
            variant === 'center' ? 'left-1/2 -translate-x-1/2' : variant === 'left' ? 'left-8 -translate-x-3' : 'right-8 translate-x-3'
          ]"
        ></div>

        <!-- Content -->
        <div
          :class="[
            variant === 'center' ? 'w-5/12' : variant === 'left' ? 'ml-20' : 'mr-20'
          ]"
        >
          <div
            :class="[
              'bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition-shadow',
              variant === 'center' ? (index % 2 === 0 ? 'text-right' : 'text-left') : ''
            ]"
          >
            <div class="text-industrial-blue font-black text-2xl mb-2">{{ item.year }}</div>
            <h3 class="text-xl font-bold mb-3">{{ item.title }}</h3>
            <p class="text-slate-600 text-sm">{{ item.description }}</p>
            <slot name="item" :item="item" :index="index" />
          </div>
        </div>

        <!-- Empty Space for Center Layout -->
        <div v-if="variant === 'center'" class="w-5/12"></div>
      </div>
    </div>
  </div>
</template>
