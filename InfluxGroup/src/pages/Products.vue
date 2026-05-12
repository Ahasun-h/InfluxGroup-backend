<script setup>
import { ref, computed } from 'vue'
import { Zap, Settings, Wind, Cpu, Filter, ArrowRight } from 'lucide-vue-next'

const activeCategory = ref('all')

const categories = [
  { id: 'all', name: 'All Products', icon: Filter },
  { id: 'transformers', name: 'Transformers', icon: Zap },
  { id: 'switchgear', name: 'Switchgear', icon: Settings },
  { id: 'renewables', name: 'Renewables', icon: Wind },
  { id: 'automation', name: 'Automation', icon: Cpu }
]

const products = [
  {
    id: 1,
    name: 'Power Transformer 250 MVA',
    category: 'transformers',
    description: 'High-capacity power transformer for utility-scale applications',
    specifications: ['250 MVA', '230/132 kV', 'ONAN/ONAF Cooling', 'IEC 60076 Compliant'],
    image: 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800',
    features: ['Low losses', 'High efficiency', 'Compact design', 'Easy maintenance']
  },
  {
    id: 2,
    name: 'Distribution Transformer',
    category: 'transformers',
    description: 'Reliable distribution transformers for residential and industrial use',
    specifications: ['25-2500 kVA', '11/0.4 kV', 'Hermetically sealed', 'Corrosion resistant'],
    image: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=800',
    features: ['Low no-load loss', 'High reliability', 'Compact size', 'Environment friendly']
  },
  {
    id: 3,
    name: 'Gas Insulated Switchgear',
    category: 'switchgear',
    description: 'SF6 gas-insulated switchgear for compact substation solutions',
    specifications: ['Up to 400 kV', '2500-4000 A', '40 kA', 'IEC 62271'],
    image: 'https://images.unsplash.com/photo-1544724569-5f546fa6629c?auto=format&fit=crop&q=80&w=800',
    features: ['Compact design', 'High reliability', 'Low maintenance', 'Enhanced safety']
  },
  {
    id: 4,
    name: 'Air Insulated Switchgear',
    category: 'switchgear',
    description: 'Versatile air-insulated switchgear for medium voltage applications',
    specifications: ['12-36 kV', '630-2500 A', '25 kA', 'Type tested'],
    image: 'https://images.unsplash.com/photo-1518709766631-a6a7f45921c3?auto=format&fit=crop&q=80&w=800',
    features: ['Easy maintenance', 'Cost-effective', 'Flexible configuration', 'Proven design']
  },
  {
    id: 5,
    name: 'Solar Inverter System',
    category: 'renewables',
    description: 'Grid-tied solar inverters for utility-scale solar farms',
    specifications: ['100-1000 kW', 'MPPT tracking', 'Grid support functions', 'THD <3%'],
    image: 'https://images.unsplash.com/photo-1509391366360-fe5bb658589d?auto=format&fit=crop&q=80&w=800',
    features: ['High efficiency', 'Grid support', 'Remote monitoring', 'Easy installation']
  },
  {
    id: 6,
    name: 'Wind Power Converter',
    category: 'renewables',
    description: 'Advanced power converters for wind turbine applications',
    specifications: ['1-5 MW', 'Full power conversion', 'Grid compliance', 'Doubly fed induction'],
    image: 'https://images.unsplash.com/photo-1532601224476-15c79f2f7a51?auto=format&fit=crop&q=80&w=800',
    features: ['High efficiency', 'Grid stability', 'Low maintenance', 'Advanced control']
  },
  {
    id: 7,
    name: 'PLC Control System',
    category: 'automation',
    description: 'Programmable logic controllers for industrial automation',
    specifications: ['Up to 10k I/O', 'Modbus TCP/IP', 'IEC 61131-3', 'Hot swappable'],
    image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&q=80&w=800',
    features: ['Flexible programming', 'High speed', 'Integrated safety', 'Remote access']
  },
  {
    id: 8,
    name: 'SCADA System',
    category: 'automation',
    description: 'Supervisory control and data acquisition for power systems',
    specifications: ['Unlimited tags', 'Redundant architecture', 'IEC 61850', 'Web-based HMI'],
    image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800',
    features: ['Real-time monitoring', 'Historical trending', 'Alarm management', 'Mobile access']
  }
]

const filteredProducts = computed(() => {
  if (activeCategory.value === 'all') return products
  return products.filter(p => p.category === activeCategory.value)
})
</script>

<template>
  <div class="min-h-screen bg-industrial-light">
    <!-- Hero Section -->
    <section class="relative py-32 bg-industrial-dark text-white overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-industrial-blue/10 to-transparent"></div>
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div v-motion-slide-visible-left>
          <div class="flex items-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">Our Products</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            ENGINEERING <span class="text-industrial-blue">EXCELLENCE</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            Comprehensive portfolio of power systems and equipment designed for reliability, efficiency, and sustainability.
          </p>
        </div>
      </div>
    </section>

    <!-- Category Filter -->
    <section class="py-8 md:py-12 bg-white border-b top-[84px] lg:top-[92px] z-40 shadow-md">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap gap-3 md:gap-4 justify-center">
          <button
            v-for="category in categories"
            :key="category.id"
            @click="activeCategory = category.id"
            class="flex items-center gap-2 px-4 md:px-6 py-2 md:py-3 rounded-sm font-bold uppercase text-[10px] md:text-xs tracking-wider transition-all"
            :class="activeCategory === category.id ? 'bg-industrial-blue text-white' : 'bg-industrial-light text-industrial-dark hover:bg-industrial-blue/10'"
          >
            <component :is="category.icon" class="w-4 h-4" />
            <span class="hidden sm:inline">{{ category.name }}</span>
            <span class="sm:hidden">{{ category.name === 'All Products' ? 'All' : category.name }}</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Products Grid -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="(product, index) in filteredProducts"
            :key="product.id"
            class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <!-- Image -->
            <div class="relative h-64 overflow-hidden">
              <img
                :src="product.image"
                :alt="product.name"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/80 to-transparent"></div>
              <div class="absolute top-4 right-4 bg-industrial-blue text-white px-3 py-1 rounded-full text-xs font-bold uppercase">
                {{ categories.find(c => c.id === product.category)?.name }}
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <h3 class="text-xl font-display font-black uppercase italic mb-3 group-hover:text-industrial-blue transition-colors">
                {{ product.name }}
              </h3>
              <p class="text-slate-600 text-sm mb-4 line-clamp-2">
                {{ product.description }}
              </p>

              <!-- Specifications -->
              <div class="mb-4">
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Key Specifications</h4>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="(spec, idx) in product.specifications.slice(0, 3)"
                    :key="idx"
                    class="bg-industrial-light text-industrial-dark px-3 py-1 rounded text-xs font-medium"
                  >
                    {{ spec }}
                  </span>
                </div>
              </div>

              <!-- Features -->
              <div class="mb-6">
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Features</h4>
                <ul class="space-y-1">
                  <li
                    v-for="(feature, idx) in product.features.slice(0, 3)"
                    :key="idx"
                    class="flex items-center gap-2 text-xs text-slate-600"
                  >
                    <div class="w-1.5 h-1.5 rounded-full bg-industrial-blue"></div>
                    {{ feature }}
                  </li>
                </ul>
              </div>

              <!-- CTA -->
              <button class="w-full bg-industrial-blue text-white py-3 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-red transition-colors flex items-center justify-center gap-2 group-hover:gap-4">
                Learn More <ArrowRight class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Need Custom <span class="text-industrial-blue">Solutions?</span>
        </h2>
        <p class="text-xl mb-12 text-slate-300">
          Our engineering team can design and manufacture products to meet your specific requirements
        </p>
        <button class="bg-industrial-blue hover:bg-industrial-red text-white px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs transition-all shadow-2xl">
          Contact Our Team
        </button>
      </div>
    </section>
  </div>
</template>
