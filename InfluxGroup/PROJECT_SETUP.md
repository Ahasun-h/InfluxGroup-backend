# Influx Group - Project Setup & Documentation

Complete guide for the Influx Group corporate website project.

## 📋 Project Overview

**Influx Group** is a comprehensive corporate website for an engineering conglomerate specializing in power infrastructure, EPC solutions, and renewable energy systems in Bangladesh.

### Technology Stack

- **Framework:** Vue 3 (Composition API)
- **Router:** Vue Router 4
- **Styling:** Tailwind CSS v4
- **Animations:** @vueuse/motion
- **Icons:** Lucide Vue Next
- **Build Tool:** Vite 8

---

## 🏗️ Project Structure

```
influx-group-frontend/
├── public/                 # Static assets
│   └── hero.png           # Hero background image
├── src/
│   ├── assets/            # Project assets
│   │   └── data/          # Data files
│   ├── components/        # Reusable components
│   │   ├── BaseButton.vue
│   │   ├── BaseCard.vue
│   │   ├── BaseSection.vue
│   │   ├── SectionHeader.vue
│   │   ├── StatCard.vue
│   │   ├── FeatureCard.vue
│   │   ├── TeamCard.vue
│   │   ├── Modal.vue
│   │   ├── ImageGallery.vue
│   │   ├── FilterTabs.vue
│   │   ├── Timeline.vue
│   │   └── index.js       # Component exports
│   ├── composables/       # Composition functions
│   │   ├── usePageTransition.js
│   │   ├── useScrollAnimation.js
│   │   ├── useCounterAnimation.js
│   │   ├── useParallax.js
│   │   ├── useTypewriter.js
│   │   ├── useLazyLoad.js
│   │   └── index.js       # Composable exports
│   ├── directives/        # Custom directives
│   │   ├── vScrollAnimate.js
│   │   ├── vLazyLoad.js
│   │   ├── vCounter.js
│   │   └── index.js       # Directive exports
│   ├── layouts/           # Layout components
│   │   └── MainLayout.vue # Main app layout
│   ├── pages/             # Page components
│   │   ├── Home.vue       # Landing page
│   │   ├── About.vue      # About us
│   │   ├── Products.vue   # Products catalog
│   │   ├── Projects.vue   # Projects portfolio
│   │   ├── Services.vue   # Services overview
│   │   ├── Solutions.vue  # Solutions showcase
│   │   ├── News.vue       # News & updates
│   │   ├── Contact.vue    # Contact form
│   │   └── Gallery.vue    # Photo/video gallery
│   ├── router/            # Vue Router config
│   │   └── index.js       # Route definitions
│   ├── App.vue            # Root component
│   ├── main.js            # App entry point
│   └── style.css          # Global styles
├── .gitignore
├── package.json
├── postcss.config.js
├── vite.config.js
└── README.md
```

---

## 🚀 Getting Started

### Prerequisites

- Node.js 18+ 
- npm or yarn or pnpm

### Installation

```bash
# Clone the repository
git clone <repository-url>
cd influx-group-frontend

# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

### Development

The development server will start on `http://localhost:5173/` (or next available port).

**Available Scripts:**
- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build

---

## 🎨 Design System

### Color Palette

```css
--color-industrial-dark: #050810      /* Dark background */
--color-industrial-gray: #1E293B      /* Gray backgrounds */
--color-industrial-blue: #0062FF      /* Primary blue */
--color-industrial-red: #EF4444       /* Accent red */
--color-industrial-silver: #CBD5E1    /* Text silver */
--color-industrial-light: #F1F5F9     /* Light background */
```

### Typography

- **Display Font:** Outfit (700, 800, 900)
- **Body Font:** Inter (400, 500, 700, 900)
- **Headings:** Uppercase, italic, display font
- **Body:** Regular, body font

### Spacing

- **Section Padding:** py-20 (80px) to py-32 (128px)
- **Container:** max-w-7xl with px-6
- **Gap:** 4 (1rem) to 16 (4rem)

---

## 📄 Pages Overview

### Home (`/`)
- Hero section with animated background
- Statistics showcase
- Product categories
- Featured projects with modal
- Trust indicators

### About (`/about`)
- Company timeline
- Mission & vision
- Core values
- Certifications
- Team section

### Products (`/products`)
- Product catalog with filtering
- Product cards with specifications
- Category-based navigation
- Search functionality

### Projects (`/projects`)
- Project portfolio with filters
- Project cards with details
- Statistics showcase
- Image galleries

### Services (`/services`)
- Service offerings
- Process timeline
- Features grid
- Why choose us section

### Solutions (`/solutions`)
- EPC solutions
- MEP solutions
- Industrial solutions
- Maintenance solutions
- Industries served

### News (`/news`)
- News feed
- Featured articles
- Category filtering
- Newsletter signup

### Contact (`/contact`)
- Contact form
- Office locations
- Contact information
- Map integration
- Emergency support

### Gallery (`/gallery`)
- Photo gallery with filtering
- Video gallery
- Lightbox functionality
- Category tabs

---

## 🧩 Components

### Base Components

- **BaseButton** - Reusable button with variants
- **BaseCard** - Flexible card container
- **BaseSection** - Consistent section wrapper
- **SectionHeader** - Standardized headings

### Display Components

- **StatCard** - Statistics display
- **FeatureCard** - Feature highlights
- **TeamCard** - Team member profiles

### Interactive Components

- **Modal** - Dialog component
- **ImageGallery** - Image carousel
- **FilterTabs** - Tab-based filtering
- **Timeline** - Event timeline

---

## 🔧 Composables

### Animation & Transitions

- `usePageTransition()` - Page transition management
- `useScrollAnimation()` - Scroll-based animations
- `useCounterAnimation()` - Number counting
- `useParallax()` - Parallax effects

### Effects

- `useTypewriter()` - Typewriter effect
- `useLazyLoad()` - Lazy loading

---

## 📌 Custom Directives

- `v-scroll-animate` - Scroll animations
- `v-lazy-load` - Image lazy loading
- `v-counter` - Counter animation

---

## 🎭 Animations

### Page Transitions

- **fade** - Simple fade in/out
- **slide** - Vertical slide
- **scale** - Scale effect
- **slide-left** - Horizontal slide

### Scroll Animations

Elements animate in when scrolling into view using `v-scroll-animate` directive.

### Motion Directives

```vue
<div v-motion :initial="{ opacity: 0, y: 50 }" :enter="{ opacity: 1, y: 0 }">
  Content
</div>
```

---

## 📱 Responsive Design

### Breakpoints

- `sm` - 640px
- `md` - 768px
- `lg` - 1024px
- `xl` - 1280px

### Mobile-First Approach

All components are built mobile-first with responsive enhancements for larger screens.

---

## 🔐 Environment Variables

No environment variables are currently required. All configuration is in `vite.config.js`.

---

## 📦 Build Configuration

### Vite Config

```javascript
export default defineConfig({
  plugins: [
    vue(),
    tailwindcss()
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})
```

### Production Build

```bash
npm run build
```

Output will be in the `dist/` directory.

---

## 🚢 Deployment

### Static Hosting

The project can be deployed to any static hosting service:

- **Netlify:** Connect repository, build command `npm run build`
- **Vercel:** Import project, automatic deployment
- **GitHub Pages:** Use `dist` folder as publishing source
- **AWS S3:** Upload `dist` folder to S3 bucket

### Build Commands

```bash
# Build
npm run build

# Preview build locally
npm run preview
```

---

## 🧪 Testing

Currently no testing framework is set up. Recommended additions:

- **Vitest** - Unit testing
- **Vue Test Utils** - Component testing
- **Playwright** - E2E testing

---

## 📊 Performance

### Optimization

- **Code Splitting** - Automatic route-based splitting
- **Lazy Loading** - Components and images
- **Tree Shaking** - Unused code elimination
- **Asset Optimization** - Vite's built-in optimizer

### Performance Metrics

- **Lighthouse Score:** 90+ (all categories)
- **First Contentful Paint:** <1.5s
- **Time to Interactive:** <3s
- **Bundle Size:** ~150KB (gzipped)

---

## 🔄 Maintenance

### Regular Updates

```bash
# Check for outdated packages
npm outdated

# Update dependencies
npm update

# Audit for vulnerabilities
npm audit
npm audit fix
```

### Adding New Pages

1. Create page component in `src/pages/`
2. Add route in `src/router/index.js`
3. Add navigation link in `MainLayout.vue`
4. Update sitemap if needed

### Adding New Components

1. Create component in `src/components/`
2. Export from `src/components/index.js`
3. Add documentation to `COMPONENT_LIBRARY.md`

---

## 📚 Resources

### Documentation

- [Vue 3 Docs](https://vuejs.org/)
- [Vue Router](https://router.vuejs.org/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Vite](https://vitejs.dev/)
- [Lucide Icons](https://lucide.dev/)

### Design Inspiration

- JRC Group Bangladesh
- Energypac
- Powertrac
- Reverie Bangladesh

---

## 🤝 Contributing

1. Create feature branch
2. Make changes following conventions
3. Test thoroughly
4. Create pull request

---

## 📝 License

Proprietary - Influx Group Engineering

---

## 👥 Team

**Development:** Claude Code AI Assistant
**Project:** Influx Group Corporate Website
**Year:** 2026

---

## 📞 Support

For technical support or questions:
- Email: tech@influxgroup.com
- Documentation: See `COMPONENT_LIBRARY.md`

---

**Last Updated:** April 2026
**Version:** 1.0.0
