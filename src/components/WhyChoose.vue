<script setup>
import { IconWorld, IconThumbUp, IconWallet, IconDiscount2, IconArrowRight } from '@tabler/icons-vue'
import { scrollToId } from '../lib/scroll'

const items = [
  { icon: IconWorld, title: 'Wide Range of Choices', text: 'Choose from thousands of flights, hotels and tours worldwide.' },
  { icon: IconThumbUp, title: 'Trusted by Travelers', text: 'Join millions of happy travelers around the world.' },
  { icon: IconWallet, title: 'Flexible & Easy Booking', text: 'Book with ease and adjust your plans if needed.' },
  { icon: IconDiscount2, title: 'Exclusive Deals', text: 'Get access to exclusive discounts and special offers.' },
]
</script>

<template>
  <section id="porque" class="max-w-7xl mx-auto px-5 lg:px-8 mt-24 scroll-mt-28">
    <h2 class="reveal text-3xl font-extrabold text-brand-900 mb-10">
      Why Choose <span class="font-script text-brand-500 text-4xl">Wanderly?</span>
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
      <!-- Features -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div v-for="it in items" :key="it.title" class="reveal flex items-start gap-3">
          <span class="shrink-0 inline-flex items-center justify-center w-11 h-11 rounded-full bg-brand-50 text-brand-600">
            <component :is="it.icon" :size="20" />
          </span>
          <div>
            <h3 class="font-semibold text-ink text-sm">{{ it.title }}</h3>
            <p class="text-xs text-muted mt-1 leading-relaxed">{{ it.text }}</p>
          </div>
        </div>
      </div>

      <!-- Tarjeta CTA -->
      <div class="reveal relative rounded-2xl overflow-hidden min-h-[300px]">
        <img
          src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=900&q=80"
          alt="Próxima aventura"
          class="absolute inset-0 w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-brand-900/45"></div>
        <div class="relative p-8 text-white max-w-sm">
          <span class="text-xs font-semibold tracking-widest text-white/80">LET'S GO!</span>
          <h3 class="text-3xl font-extrabold mt-2 leading-tight">Your Next Adventure Awaits!</h3>
          <p class="text-sm text-white/85 mt-3">Discover breathtaking places and create unforgettable memories.</p>
          <button class="mt-6 inline-flex items-center gap-2 bg-white text-brand-700 font-semibold px-6 py-3 rounded-full hover:bg-brand-50 transition-colors" @click="scrollToId('contacto')">
            Plan Your Trip <IconArrowRight :size="16" />
          </button>
        </div>
      </div>
    </div>
  </section>
</template>
