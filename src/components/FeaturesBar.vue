<script setup>
import { IconTag, IconHeadset, IconShieldCheck, IconRosette } from '@tabler/icons-vue'

const features = [
  { icon: IconTag, title: 'Best Price Guarantee', text: 'We ensure you get the best deals always.' },
  { icon: IconHeadset, title: '24/7 Customer Support', text: "We're here to help you anytime, anywhere." },
  { icon: IconShieldCheck, title: 'Secure Bookings', text: 'Your data and payments are 100% safe with us.' },
  { icon: IconRosette, title: 'Handpicked Experiences', text: 'Curated tours and hotels for unforgettable trips.' },
]
</script>

<template>
  <section class="max-w-7xl mx-auto px-5 lg:px-8 mt-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div v-for="f in features" :key="f.title" class="feature-item flex items-start gap-3">
        <span class="shrink-0 inline-flex items-center justify-center w-12 h-12 rounded-full bg-brand-50 text-brand-600">
          <component :is="f.icon" :size="22" />
        </span>
        <div>
          <h3 class="font-semibold text-ink text-sm">{{ f.title }}</h3>
          <p class="text-xs text-muted mt-1 leading-relaxed">{{ f.text }}</p>
        </div>
      </div>
    </div>
  </section>
</template>
