<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Briefcase, X, Phone, Mail, ArrowRight, ShieldCheck, Loader2, CheckCircle2 } from 'lucide-vue-next'
import { api } from '../services/api'

const isOpen = ref(false)
const isVisible = ref(false)
const showQuoteForm = ref(false)

// Form state
const formData = ref({
  name: '',
  email: '',
  phone: '',
  company: '',
  requirements: ''
})

const formErrors = ref({})
const isSubmitting = ref(false)
const submitSuccess = ref(false)
const submitError = ref('')

const toggleChat = () => {
  isOpen.value = !isOpen.value
}

const closeChat = () => {
  isOpen.value = false
}

const openQuoteForm = () => {
  showQuoteForm.value = true
  closeChat()
}

const closeQuoteForm = () => {
  showQuoteForm.value = false
  resetForm()
}

const resetForm = () => {
  formData.value = {
    name: '',
    email: '',
    phone: '',
    company: '',
    requirements: ''
  }
  formErrors.value = {}
  submitError.value = ''
  submitSuccess.value = false
}

const validateForm = () => {
  const errors = {}

  if (!formData.value.name.trim()) {
    errors.name = 'Name is required'
  }

  if (!formData.value.email.trim()) {
    errors.email = 'Email is required'
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.value.email)) {
    errors.email = 'Please enter a valid email'
  }

  if (!formData.value.phone.trim()) {
    errors.phone = 'Phone number is required'
  }

  if (!formData.value.requirements.trim()) {
    errors.requirements = 'Please tell us about your requirements'
  } else if (formData.value.requirements.trim().length < 10) {
    errors.requirements = 'Requirements must be at least 10 characters'
  }

  formErrors.value = errors
  return Object.keys(errors).length === 0
}

const submitQuoteRequest = async () => {
  if (!validateForm()) {
    return
  }

  isSubmitting.value = true
  submitError.value = ''

  try {
    const response = await api.post('/quote-requests/submit', {
      name: formData.value.name.trim(),
      email: formData.value.email.trim(),
      phone: formData.value.phone.trim(),
      company: formData.value.company.trim(),
      requirements: formData.value.requirements.trim()
    })

    if (response.success) {
      submitSuccess.value = true
      // Auto-close after 3 seconds on success
      setTimeout(() => {
        closeQuoteForm()
      }, 3000)
    } else {
      submitError.value = response.message || 'Failed to submit quote request. Please try again.'
    }
  } catch (error) {
    console.error('Quote request error:', error)
    submitError.value = error.message || 'An error occurred. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}

// Show button after scrolling down
const handleScroll = () => {
  isVisible.value = window.scrollY > 400
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  // Check initial scroll position
  handleScroll()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
  <!-- Floating Quote Button -->
  <Transition
    enter-active-class="transition-all duration-300"
    enter-from-class="opacity-0 translate-y-8"
    enter-to-class="opacity-100 translate-y-0"
    leave-active-class="transition-all duration-200"
    leave-from-class="opacity-100 translate-y-0"
    leave-to-class="opacity-0 translate-y-8"
  >
    <div
      v-if="isVisible"
      class="fixed bottom-6 right-6 z-40"
      :class="isOpen || showQuoteForm ? 'z-50' : 'z-40'"
    >
      <!-- Main Button -->
      <button
        v-if="!isOpen && !showQuoteForm"
        @click="toggleChat"
        class="flex items-center gap-3 bg-industrial-blue hover:bg-industrial-red text-white px-5 py-4 rounded-full font-black uppercase tracking-wider text-xs transition-all duration-300 shadow-2xl hover:shadow-industrial-blue/50 hover:scale-105 active:scale-95 animate-pulse-hover"
      >
        <Briefcase class="w-5 h-5" />
        <span class="hidden sm:inline">Get Quote</span>
        <span class="sm:hidden">Quote</span>
      </button>

      <!-- Expanded Panel -->
      <Transition
        enter-active-class="transition-all duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition-all duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-if="isOpen"
          class="bg-white rounded-2xl shadow-2xl p-6 mb-4 min-w-[320px]"
        >
          <!-- Header -->
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="text-lg font-display font-black uppercase italic text-industrial-dark">
                Get Your Quote
              </h3>
              <p class="text-xs text-slate-500">Quick response guaranteed</p>
            </div>
            <button
              @click="closeChat"
              class="w-8 h-8 bg-slate-100 hover:bg-slate-200 rounded-full flex items-center justify-center transition-colors"
            >
              <X class="w-4 h-4 text-slate-600" />
            </button>
          </div>

          <!-- Contact Options -->
          <div class="space-y-3">
            <a
              href="tel:+88029876543"
              class="flex items-center gap-3 p-3 bg-industrial-light hover:bg-industrial-blue hover:text-white rounded-lg transition-colors group"
            >
              <div class="w-10 h-10 bg-industrial-blue rounded-full flex items-center justify-center group-hover:bg-white">
                <Phone class="w-5 h-5 text-white group-hover:text-industrial-blue" />
              </div>
              <div class="flex-1">
                <div class="text-xs font-bold text-industrial-dark">Call Us</div>
                <div class="text-xs text-slate-500">+880 2 987 6543</div>
              </div>
            </a>

            <a
              href="mailto:info@influxgroup.com"
              class="flex items-center gap-3 p-3 bg-industrial-light hover:bg-industrial-blue hover:text-white rounded-lg transition-colors group"
            >
              <div class="w-10 h-10 bg-industrial-blue rounded-full flex items-center justify-center group-hover:bg-white">
                <Mail class="w-5 h-5 text-white group-hover:text-industrial-blue" />
              </div>
              <div class="flex-1">
                <div class="text-xs font-bold text-industrial-dark">Email Us</div>
                <div class="text-xs text-slate-500">info@influxgroup.com</div>
              </div>
            </a>

            <button
              @click="openQuoteForm"
              class="flex items-center justify-center gap-2 w-full py-3 bg-industrial-blue hover:bg-industrial-red text-white rounded-lg font-black uppercase tracking-wider text-xs transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 active:scale-95"
            >
              <Briefcase class="w-4 h-4" />
              Request Quote
              <ArrowRight class="w-4 h-4" />
            </button>
          </div>

          <!-- Trust Badge -->
          <div class="mt-4 pt-4 border-t border-slate-200">
            <div class="flex items-center gap-2 text-[10px] text-slate-600">
              <ShieldCheck class="w-4 h-4 text-green-500" />
              <span class="font-bold">Trusted by 250+ companies</span>
            </div>
          </div>
        </div>
      </Transition>

      <!-- Quote Request Form Modal -->
      <Teleport to="body">
        <Transition
          enter-active-class="transition-all duration-300"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="transition-all duration-200"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div
            v-if="showQuoteForm"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @click.self="closeQuoteForm"
          >
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

            <!-- Modal Content -->
            <Transition
              enter-active-class="transition-all duration-300"
              enter-from-class="opacity-0 scale-95"
              enter-to-class="opacity-100 scale-100"
              leave-active-class="transition-all duration-200"
              leave-from-class="opacity-100 scale-100"
              leave-to-class="opacity-0 scale-95"
            >
              <div
                v-if="showQuoteForm"
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-hidden flex flex-col"
              >
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b bg-gradient-to-r from-industrial-blue to-industrial-dark">
                  <div>
                    <h3 class="text-xl font-display font-black uppercase italic text-white">
                      Request a Quote
                    </h3>
                    <p class="text-xs text-industrial-light opacity-90">Fill in your details and we'll get back to you</p>
                  </div>
                  <button
                    @click="closeQuoteForm"
                    class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors flex-shrink-0"
                  >
                    <X class="w-5 h-5" />
                  </button>
                </div>

                <!-- Body -->
                <div class="flex-1 overflow-y-auto p-6">
                  <!-- Success Message -->
                  <div
                    v-if="submitSuccess"
                    class="flex flex-col items-center justify-center py-8 text-center"
                  >
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4">
                      <CheckCircle2 class="w-12 h-12 text-green-500" />
                    </div>
                    <h4 class="text-2xl font-black text-industrial-dark mb-2">Thank You!</h4>
                    <p class="text-slate-600 mb-4">Your quote request has been submitted successfully.</p>
                    <p class="text-sm text-slate-500">We'll get back to you within 24 hours.</p>
                  </div>

                  <!-- Quote Form -->
                  <form v-else @submit.prevent="submitQuoteRequest" class="space-y-4">
                    <!-- Name -->
                    <div>
                      <label class="block text-sm font-bold text-industrial-dark mb-2">
                        Full Name <span class="text-red-500">*</span>
                      </label>
                      <input
                        v-model="formData.name"
                        type="text"
                        placeholder="John Doe"
                        :class="['w-full px-4 py-3 rounded-lg border transition-colors text-gray-900 placeholder:text-gray-400', formErrors.name ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-white hover:border-industrial-blue focus:border-industrial-blue focus:ring-2 focus:ring-industrial-blue/20']"
                        :disabled="isSubmitting"
                      />
                      <p v-if="formErrors.name" class="text-red-500 text-xs mt-1">{{ formErrors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                      <label class="block text-sm font-bold text-industrial-dark mb-2">
                        Email Address <span class="text-red-500">*</span>
                      </label>
                      <input
                        v-model="formData.email"
                        type="email"
                        placeholder="john@example.com"
                        :class="['w-full px-4 py-3 rounded-lg border transition-colors text-gray-900 placeholder:text-gray-400', formErrors.email ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-white hover:border-industrial-blue focus:border-industrial-blue focus:ring-2 focus:ring-industrial-blue/20']"
                        :disabled="isSubmitting"
                      />
                      <p v-if="formErrors.email" class="text-red-500 text-xs mt-1">{{ formErrors.email }}</p>
                    </div>

                    <!-- Phone -->
                    <div>
                      <label class="block text-sm font-bold text-industrial-dark mb-2">
                        Phone Number <span class="text-red-500">*</span>
                      </label>
                      <input
                        v-model="formData.phone"
                        type="tel"
                        placeholder="+880 1234-567890"
                        :class="['w-full px-4 py-3 rounded-lg border transition-colors text-gray-900 placeholder:text-gray-400', formErrors.phone ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-white hover:border-industrial-blue focus:border-industrial-blue focus:ring-2 focus:ring-industrial-blue/20']"
                        :disabled="isSubmitting"
                      />
                      <p v-if="formErrors.phone" class="text-red-500 text-xs mt-1">{{ formErrors.phone }}</p>
                    </div>

                    <!-- Company (Optional) -->
                    <div>
                      <label class="block text-sm font-bold text-industrial-dark mb-2">
                        Company Name
                      </label>
                      <input
                        v-model="formData.company"
                        type="text"
                        placeholder="ABC Corporation"
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 bg-white hover:border-industrial-blue focus:border-industrial-blue focus:ring-2 focus:ring-industrial-blue/20 transition-colors text-gray-900 placeholder:text-gray-400"
                        :disabled="isSubmitting"
                      />
                    </div>

                    <!-- Requirements -->
                    <div>
                      <label class="block text-sm font-bold text-industrial-dark mb-2">
                        Your Requirements <span class="text-red-500">*</span>
                      </label>
                      <textarea
                        v-model="formData.requirements"
                        rows="4"
                        placeholder="Please describe your project requirements, timeline, budget, etc..."
                        :class="['w-full px-4 py-3 rounded-lg border transition-colors resize-none text-gray-900 placeholder:text-gray-400', formErrors.requirements ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-white hover:border-industrial-blue focus:border-industrial-blue focus:ring-2 focus:ring-industrial-blue/20']"
                        :disabled="isSubmitting"
                      ></textarea>
                      <p v-if="formErrors.requirements" class="text-red-500 text-xs mt-1">{{ formErrors.requirements }}</p>
                    </div>

                    <!-- Error Message -->
                    <div
                      v-if="submitError"
                      class="p-3 bg-red-100 border border-red-300 rounded-lg text-red-700 text-sm"
                    >
                      {{ submitError }}
                    </div>
                  </form>
                </div>

                <!-- Footer -->
                <div v-if="!submitSuccess" class="p-6 border-t bg-slate-50">
                  <button
                    @click="submitQuoteRequest"
                    :disabled="isSubmitting"
                    class="w-full py-3 bg-industrial-blue hover:bg-industrial-red text-white rounded-lg font-black uppercase tracking-wider text-xs transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none flex items-center justify-center gap-2"
                  >
                    <Loader2 v-if="isSubmitting" class="w-4 h-4 animate-spin" />
                    <Briefcase v-else class="w-4 h-4" />
                    {{ isSubmitting ? 'Submitting...' : 'Submit Quote Request' }}
                    <ArrowRight v-if="!isSubmitting" class="w-4 h-4" />
                  </button>
                  <p class="text-center text-xs text-slate-500 mt-3">
                    By submitting, you agree to our privacy policy
                  </p>
                </div>
              </div>
            </Transition>
          </div>
        </Transition>
      </Teleport>
    </div>
  </Transition>
</template>

<style scoped>
.animate-pulse:hover {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: .8;
  }
}
</style>