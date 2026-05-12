<script setup>
import { ref } from 'vue'
import { MapPin, Phone, Mail, Clock, Send, Building2 } from 'lucide-vue-next'

const contactForm = ref({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: ''
})

const offices = [
  {
    city: 'Dhaka',
    type: 'Corporate Headquarters',
    address: 'Level 12, Energy Plaza, Tejgaon I/A',
    phone: '+880 2 987 6543',
    email: 'dhaka@influxgroup.com'
  },
  {
    city: 'Chittagong',
    type: 'Regional Office',
    address: 'Plot 45, GEC Circle, Nasirabad',
    phone: '+880 31 654 321',
    email: 'ctg@influxgroup.com'
  }
]
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
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">Contact Us</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            GET IN <span class="text-industrial-blue">TOUCH</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            Ready to discuss your next project? Contact our team for expert consultation and solutions.
          </p>
        </div>
      </div>
    </section>

    <!-- Contact Info & Form -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16">
          <!-- Contact Form -->
          <div v-motion-slide-visible-left>
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Send Us a <span class="text-industrial-blue">Message</span>
            </h2>

            <form @submit.prevent class="space-y-6">
              <div class="grid md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Full Name *</label>
                  <input
                    v-model="contactForm.name"
                    type="text"
                    required
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors"
                    placeholder="John Doe"
                  />
                </div>
                <div>
                  <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Email Address *</label>
                  <input
                    v-model="contactForm.email"
                    type="email"
                    required
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors"
                    placeholder="john@example.com"
                  />
                </div>
              </div>

              <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Phone Number</label>
                <input
                  v-model="contactForm.phone"
                  type="tel"
                  class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors"
                  placeholder="+880 1XXX-XXXXXX"
                />
              </div>

              <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Subject *</label>
                <select
                  v-model="contactForm.subject"
                  required
                  class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors bg-white"
                >
                  <option value="">Select a subject</option>
                  <option value="general">General Inquiry</option>
                  <option value="projects">Project Inquiry</option>
                  <option value="products">Product Information</option>
                  <option value="support">Technical Support</option>
                  <option value="careers">Career Opportunities</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Message *</label>
                <textarea
                  v-model="contactForm.message"
                  required
                  rows="6"
                  class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors resize-none"
                  placeholder="Tell us about your project or inquiry..."
                ></textarea>
              </div>

              <button
                type="submit"
                class="w-full bg-industrial-blue hover:bg-industrial-red text-white py-4 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3"
              >
                Send Message <Send class="w-4 h-4" />
              </button>
            </form>
          </div>

          <!-- Contact Information -->
          <div v-motion-slide-visible-right>
            <h2 class="text-3xl font-display font-black uppercase italic mb-8">
              Contact <span class="text-industrial-blue">Information</span>
            </h2>

            <div class="space-y-8 mb-12">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                  <Phone class="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 class="font-bold text-lg mb-2">Phone</h3>
                  <p class="text-slate-600">+880 2 987 6543</p>
                  <p class="text-slate-600">+880 1XXX-XXXXXX</p>
                </div>
              </div>

              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                  <Mail class="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 class="font-bold text-lg mb-2">Email</h3>
                  <p class="text-slate-600">info@influxgroup.com</p>
                  <p class="text-slate-600">sales@influxgroup.com</p>
                </div>
              </div>

              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                  <Clock class="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 class="font-bold text-lg mb-2">Office Hours</h3>
                  <p class="text-slate-600">Saturday - Thursday: 9:00 AM - 6:00 PM</p>
                  <p class="text-slate-600">Friday: Closed</p>
                </div>
              </div>
            </div>

            <!-- Office Locations -->
            <h3 class="text-xl font-bold mb-6">Our Offices</h3>
            <div class="space-y-6">
              <div
                v-for="(office, index) in offices"
                :key="index"
                class="bg-industrial-light p-6 rounded-lg"
              >
                <div class="flex items-start gap-4 mb-4">
                  <Building2 class="w-6 h-6 text-industrial-blue flex-shrink-0 mt-1" />
                  <div>
                    <h4 class="font-bold text-lg mb-1">{{ office.city }}</h4>
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">{{ office.type }}</p>
                    <p class="text-slate-600 text-sm mb-2">{{ office.address }}</p>
                    <p class="text-slate-600 text-sm">{{ office.phone }}</p>
                    <p class="text-slate-600 text-sm">{{ office.email }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Map Section -->
    <section class="h-96 bg-slate-200">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.3832277878897!2d90.4125!3d23.8104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQ4JzM3LjQiTiA5MMKwMjQnNDUuMCJF!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd"
        width="100%"
        height="100%"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
      ></iframe>
    </section>

    <!-- Quick Contact -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Emergency <span class="text-industrial-red">Support</span>
        </h2>
        <p class="text-xl mb-12 text-slate-300">
          24/7 emergency support available for critical power infrastructure issues
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
          <a href="tel:+88029876543" class="bg-industrial-red hover:bg-red-700 text-white px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3">
            <Phone class="w-5 h-5" />
            Emergency Line
          </a>
          <a href="mailto:support@influxgroup.com" class="bg-white text-industrial-dark hover:bg-industrial-light px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3">
            <Mail class="w-5 h-5" />
            Email Support
          </a>
        </div>
      </div>
    </section>
  </div>
</template>
