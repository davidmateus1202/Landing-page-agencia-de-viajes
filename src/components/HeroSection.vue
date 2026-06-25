<script setup>
import { IconPlane, IconArrowRight } from '@tabler/icons-vue'
import { scrollToId } from '../lib/scroll'
</script>

<template>
  <section class="relative pt-20">
    <!-- Imagen de fondo (mitad derecha) -->
    <div class="absolute inset-0 -z-10">
      <div class="absolute inset-0 bg-brand-50"></div>
      <img
        src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=1400&q=80"
        alt="Santorini, Grecia"
        class="absolute right-0 top-0 h-full w-[58%] object-cover"
      />
      <!-- velo sólido para fundir la imagen con el fondo claro -->
      <div class="absolute right-0 top-0 h-full w-[58%] bg-brand-50/30"></div>
      <div class="absolute left-[40%] top-0 h-full w-[22%] bg-brand-50" style="filter: blur(40px)"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-14 pb-44 lg:pt-20 lg:pb-52">
      <div class="max-w-xl">
        <span class="hero-badge pre-anim inline-flex items-center gap-2 glass px-4 py-2 rounded-full text-xs font-semibold text-brand-700">
          <IconPlane :size="14" /> EXPLORE. DREAM. DISCOVER.
        </span>

        <h1 class="hero-title mt-6 text-5xl lg:text-6xl font-extrabold leading-[1.05] text-brand-900">
          <span class="pre-anim block">Discover Amazing</span>
          <span class="pre-anim block font-script font-bold text-brand-500 text-6xl lg:text-7xl mt-1">Places with Us</span>
        </h1>

        <p class="hero-text pre-anim mt-6 text-muted max-w-md">
          Find the best tours, hotels and flights: everything you need for the perfect trip.
        </p>

        <button
          class="hero-cta pre-anim mt-8 inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold px-7 py-3.5 rounded-full transition-colors shadow-lg shadow-brand-500/30"
          @click="scrollToId('destinos')"
        >
          Explore Now <IconArrowRight :size="18" />
        </button>
      </div>
    </div>
  </section>
</template>
