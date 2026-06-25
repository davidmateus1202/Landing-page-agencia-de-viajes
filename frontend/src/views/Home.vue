<script setup>
import { onMounted, ref } from 'vue'
import { useContentStore } from '../stores/content'
import { gsap, reduceMotion, revealOnScroll } from '../lib/gsap'

import IntroLoader from '../components/IntroLoader.vue'
import AppNavbar from '../components/AppNavbar.vue'
import HeroSection from '../components/HeroSection.vue'
import SearchBar from '../components/SearchBar.vue'
import FeaturesBar from '../components/FeaturesBar.vue'
import PopularDestinations from '../components/PopularDestinations.vue'
import WhyChoose from '../components/WhyChoose.vue'
import PlansSection from '../components/PlansSection.vue'
import ContactSection from '../components/ContactSection.vue'
import NewsletterFooter from '../components/NewsletterFooter.vue'
import WhatsAppButton from '../components/WhatsAppButton.vue'

const content = useContentStore()
const root = ref(null)

onMounted(() => {
  content.load()
})

// Se dispara cuando termina la intro: anima el hero + activa reveals al hacer scroll.
function startReveals() {
  if (reduceMotion) {
    document.querySelectorAll('.pre-anim').forEach((el) => (el.style.visibility = 'visible'))
    return
  }

  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } })
  tl.set('.pre-anim', { visibility: 'visible' })
    .from('.logo-plane', { x: -120, opacity: 0, duration: 0.7 })
    .from('.hero-badge', { y: 20, opacity: 0, duration: 0.5 }, '-=0.3')
    .from('.hero-title .pre-anim', { y: 40, opacity: 0, duration: 0.7, stagger: 0.15 }, '-=0.2')
    .from('.hero-text', { y: 20, opacity: 0, duration: 0.5 }, '-=0.3')
    .from('.hero-cta', { y: 20, opacity: 0, duration: 0.5 }, '-=0.3')
    .from('.search-bar', { y: 60, opacity: 0, duration: 0.8 }, '-=0.2')

  // Beneficios con stagger
  revealOnScroll('.feature-item', root.value)
  // Resto de secciones
  revealOnScroll('.reveal', root.value)
}
</script>

<template>
  <div ref="root">
    <IntroLoader @done="startReveals" />

    <AppNavbar :settings="content.settings" />

    <main>
      <HeroSection />
      <SearchBar />
      <FeaturesBar />
      <PopularDestinations :destinations="content.destinations" />
      <WhyChoose />
      <PlansSection :plans="content.plans" />
      <ContactSection :settings="content.settings" />
    </main>

    <NewsletterFooter :settings="content.settings" />
    <WhatsAppButton :number="content.settings.whatsapp_number" />
  </div>
</template>
