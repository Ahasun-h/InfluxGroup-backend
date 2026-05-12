# Influx Group - Component Library Documentation

Complete documentation for reusable components and composables in the Influx Group project.

## 📦 Table of Contents

- [Base Components](#base-components)
- [Display Components](#display-components)
- [Interactive Components](#interactive-components)
- [Composables](#composables)
- [Directives](#directives)
- [Usage Examples](#usage-examples)

---

## 🎨 Base Components

### BaseButton

Reusable button component with multiple variants and sizes.

**Props:**
- `variant` - 'primary' | 'secondary' | 'outline' | 'ghost' (default: 'primary')
- `size` - 'small' | 'medium' | 'large' (default: 'medium')
- `loading` - Boolean (default: false)
- `disabled` - Boolean (default: false)
- `icon` - Boolean (default: false)

**Events:**
- `click` - Emitted when button is clicked

**Example:**
```vue
<BaseButton
  variant="primary"
  size="large"
  :loading="isLoading"
  @click="handleSubmit"
>
  Submit Form
</BaseButton>
```

---

### BaseCard

Flexible card container component with variants.

**Props:**
- `variant` - 'default' | 'glass' | 'bordered' | 'elevated' (default: 'default')
- `hover` - Boolean (default: false)
- `padding` - 'none' | 'small' | 'normal' | 'large' (default: 'normal')

**Example:**
```vue
<BaseCard variant="glass" hover padding="large">
  <h3>Card Title</h3>
  <p>Card content goes here...</p>
</BaseCard>
```

---

### BaseSection

Section wrapper with consistent styling.

**Props:**
- `variant` - 'light' | 'dark' | 'blue' | 'white' (default: 'light')
- `padding` - 'none' | 'small' | 'medium' | 'large' | 'xl' (default: 'large')
- `container` - Boolean (default: true)

**Example:**
```vue
<BaseSection variant="dark" padding="xl">
  <SectionHeader
    title="Section Title"
    subtitle="Section description"
    alignment="center"
  />
  <p>Section content...</p>
</BaseSection>
```

---

### SectionHeader

Consistent section heading component.

**Props:**
- `title` - String (required)
- `subtitle` - String (default: '')
- `alignment` - 'left' | 'center' | 'right' (default: 'left')
- `variant` - 'light' | 'dark' | 'blue' (default: 'dark')
- `size` - 'medium' | 'large' | 'xl' (default: 'large')

**Example:**
```vue
<SectionHeader
  title="Our Services"
  subtitle="Comprehensive solutions for your business"
  alignment="center"
  variant="dark"
  size="xl"
/>
```

---

## 🎯 Display Components

### StatCard

Display statistics with optional trends.

**Props:**
- `value` - String (required)
- `label` - String (required)
- `trend` - '' | 'up' | 'down' (default: '')
- `trendValue` - String (default: '')
- `variant` - 'blue' | 'red' | 'green' | 'white' (default: 'blue')

**Example:**
```vue
<StatCard
  value="250+"
  label="Projects Completed"
  trend="up"
  trendValue="12%"
  variant="blue"
/>
```

---

### FeatureCard

Display features with icons.

**Props:**
- `icon` - Component (required)
- `title` - String (required)
- `description` - String (required)
- `variant` - 'default' | 'glass' | 'bordered' (default: 'default')
- `size` - 'small' | 'medium' | 'large' (default: 'medium')

**Example:**
```vue
<FeatureCard
  :icon="Zap"
  title="Fast Installation"
  description="Quick and efficient setup process"
  variant="glass"
  size="large"
/>
```

---

### TeamCard

Display team member information.

**Props:**
- `name` - String (required)
- `role` - String (required)
- `expertise` - String (default: '')
- `image` - String (required)
- `variant` - 'default' | 'compact' | 'minimal' (default: 'default')

**Example:**
```vue
<TeamCard
  name="John Doe"
  role="Chief Engineer"
  expertise="Power Systems"
  image="/team/john.jpg"
  variant="compact"
/>
```

---

## 🔄 Interactive Components

### Modal

Reusable modal dialog component.

**Props:**
- `show` - Boolean (required)
- `title` - String (default: '')
- `size` - 'small' | 'medium' | 'large' | 'xlarge' (default: 'medium')
- `closeOnBackdrop` - Boolean (default: true)

**Events:**
- `close` - Emitted when modal should close

**Slots:**
- `header` - Custom header content
- `default` - Modal body content
- `footer` - Custom footer content

**Example:**
```vue
<Modal
  v-model:show="isModalOpen"
  title="Project Details"
  size="large"
  @close="isModalOpen = false"
>
  <p>Modal content...</p>
  <template #footer>
    <BaseButton @click="isModalOpen = false">Close</BaseButton>
  </template>
</Modal>
```

---

### ImageGallery

Image gallery with thumbnails and navigation.

**Props:**
- `images` - Array (required) - [{ src, title, description }]
- `autoplay` - Boolean (default: false)
- `interval` - Number (default: 5000)

**Example:**
```vue
<ImageGallery
  :images="galleryImages"
  :autoplay="true"
  :interval="3000"
/>
```

---

### FilterTabs

Tab-based filter component.

**Props:**
- `options` - Array (required) - [{ id, name, icon }]
- `modelValue` - String | Number (required)
- `variant` - 'pills' | 'underline' | 'buttons' (default: 'pills')
- `alignment` - 'left' | 'center' | 'right' (default: 'center')

**Events:**
- `update:modelValue` - Emitted when filter changes

**Example:**
```vue
<FilterTabs
  v-model="activeFilter"
  :options="filterOptions"
  variant="pills"
  alignment="center"
/>
```

---

### Timeline

Timeline component for displaying events.

**Props:**
- `items` - Array (required) - [{ year, title, description }]
- `variant` - 'center' | 'left' | 'right' (default: 'center')

**Example:**
```vue
<Timeline
  :items="timelineItems"
  variant="center"
>
  <template #item="{ item, index }">
    <div class="extra-content">{{ item.extra }}</div>
  </template>
</Timeline>
```

---

## 🔧 Composables

### usePageTransition

Handle page transitions between routes.

**Returns:**
- `isTransitioning` - Ref<Boolean>
- `transitionName` - Ref<String>
- `setTransition` - Function
- `pageTransitions` - Object with transition configs

**Example:**
```vue
<script setup>
import { usePageTransition } from '@/composables'

const { transitionName, setTransition } = usePageTransition()
</script>
```

---

### useScrollAnimation

Animate elements when they scroll into view.

**Returns:**
- `isVisible` - Ref<Boolean>
- `elementRef` - Ref

**Example:**
```vue
<script setup>
import { useScrollAnimation } from '@/composables'

const { isVisible, elementRef } = useScrollAnimation()
</script>

<template>
  <div ref="elementRef" :class="{ 'is-visible': isVisible }">
    Content animates in when visible
  </div>
</template>
```

---

### useCounterAnimation

Animate number counting.

**Parameters:**
- `targetValue` - Number
- `duration` - Number (default: 2000)

**Returns:**
- `currentValue` - Ref<Number>
- `isAnimating` - Ref<Boolean>
- `animate` - Function

**Example:**
```vue
<script setup>
import { useCounterAnimation } from '@/composables'

const { currentValue, animate } = useCounterAnimation(250, 2000)
onMounted(() => animate())
</script>
```

---

### useParallax

Create parallax scrolling effects.

**Parameters:**
- `speed` - Number (default: 0.5)

**Returns:**
- `elementRef` - Ref
- `translate` - Ref<{ x, y }>

**Example:**
```vue
<script setup>
import { useParallax } from '@/composables'

const { elementRef, translate } = useParallax(0.5)
</script>

<template>
  <div ref="elementRef" :style="{ transform: \`translateY(${translate.y}px)\` }">
    Parallax content
  </div>
</template>
```

---

### useTypewriter

Typewriter effect for text.

**Parameters:**
- `text` - String
- `options` - Object (speed, delay, cursor, loop, loopDelay)

**Returns:**
- `displayedText` - Ref<String>
- `showCursor` - Ref<Boolean>
- `isTyping` - Ref<Boolean>

**Example:**
```vue
<script setup>
import { useTypewriter } from '@/composables'

const { displayedText } = useTypewriter('Hello World', {
  speed: 100,
  delay: 500,
  loop: true
})
</script>
```

---

### useLazyLoad

Lazy load images and content.

**Returns:**
- `isLoaded` - Ref<Boolean>
- `elementRef` - Ref

**Example:**
```vue
<script setup>
import { useLazyLoad } from '@/composables'

const { isLoaded, elementRef } = useLazyLoad()
</script>

<template>
  <div ref="elementRef" v-if="isLoaded">
    Content loads when visible
  </div>
</template>
```

---

## 📌 Directives

### v-scroll-animate

Animate elements when they scroll into view.

**Example:**
```vue
<div v-scroll-animate class="scroll-animate">
  This element will animate when visible
</div>
```

---

### v-lazy-load

Lazy load images.

**Example:**
```vue
<img
  v-lazy-load="'/path/to/image.jpg'"
  alt="Description"
/>
```

---

### v-counter

Animate number counting when visible.

**Example:**
```vue
<span v-counter="250">0</span>
```

---

## 💡 Usage Examples

### Complete Page Example

```vue
<script setup>
import { ref, onMounted } from 'vue'
import {
  BaseSection,
  SectionHeader,
  StatCard,
  FeatureCard
} from '@/components'
import { Zap, ShieldCheck, Award } from 'lucide-vue-next'

const stats = [
  { value: '250+', label: 'Projects' },
  { value: '45+', label: 'Years' },
  { value: '99%', label: 'Satisfaction' }
]

const features = [
  {
    icon: Zap,
    title: 'Fast Delivery',
    description: 'Quick turnaround times'
  },
  // ... more features
]
</script>

<template>
  <BaseSection variant="dark" padding="xl">
    <SectionHeader
      title="Why Choose Us"
      subtitle="Our commitment to excellence"
      alignment="center"
      variant="dark"
    />

    <div class="grid md:grid-cols-3 gap-8 mb-16">
      <StatCard
        v-for="stat in stats"
        :key="stat.label"
        v-bind="stat"
      />
    </div>

    <div class="grid md:grid-cols-2 gap-8">
      <FeatureCard
        v-for="feature in features"
        :key="feature.title"
        v-bind="feature"
        variant="glass"
      />
    </div>
  </BaseSection>
</template>
```

---

## 🎨 Styling

All components use Tailwind CSS v4 with custom industrial theme colors:

- `industrial-dark` - #050810
- `industrial-blue` - #0062FF
- `industrial-red` - #EF4444
- `industrial-silver` - #CBD5E1
- `industrial-light` - #F1F5F9

---

## 📝 Best Practices

1. **Use components consistently** - Prefer base components over custom divs
2. **Compose, don't repeat** - Use slots to customize components
3. **Lazy load routes** - All pages are lazy-loaded by default
4. **Use composables** - Extract reusable logic into composables
5. **Follow conventions** - Stick to established patterns for consistency

---

## 🚀 Performance Tips

1. **Page transitions** - Use appropriate transition types per page
2. **Image optimization** - Use lazy loading for images
3. **Code splitting** - Components are auto-split by Vite
4. **Animation timing** - Use CSS transforms over layout changes
5. **Debounce scroll events** - Composables handle this automatically

---

## 📚 Additional Resources

- [Vue 3 Documentation](https://vuejs.org/)
- [Tailwind CSS v4](https://tailwindcss.com/)
- [Vue Router](https://router.vuejs.org/)
- [Lucide Icons](https://lucide.dev/)
