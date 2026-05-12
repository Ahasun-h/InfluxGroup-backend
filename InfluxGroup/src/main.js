import { createApp } from 'vue'
import { MotionPlugin } from '@vueuse/motion'
import App from './App.vue'
import router from './router'
import { registerDirectives } from './directives'
import './style.css'

const app = createApp(App)

app.use(router)
app.use(MotionPlugin)

// Register custom directives
registerDirectives(app)

app.mount('#app')
