<script setup>
import { onMounted, ref } from 'vue'
import { IconArrowRight, IconPlane } from '@tabler/icons-vue'
import DestinationCard from './DestinationCard.vue'
import { staggerReveal } from '../lib/gsap'
import { scrollToId } from '../lib/scroll'

defineProps({ destinations: { type: Array, default: () => [] } })
const root = ref(null)

onMounted(() => {
  staggerReveal('.destination-card', root.value)
})
</script>

<template>
  <section id="destinos" ref="root" class="max-w-7xl mx-auto px-5 lg:px-8 mt-24 scroll-mt-28">
    <div class="flex items-end justify-between mb-8">
      <div>
        <h2 class="text-3xl font-extrabold text-brand-900 flex items-center gap-3">
          Popular Destinations
          <IconPlane :size="22" class="text-brand-300" />
        </h2>
      </div>
      <button class="glass inline-flex items-center gap-2 text-brand-600 text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-brand-50 transition-colors" @click="scrollToId('planes')">
        View All Destinations <IconArrowRight :size="16" />
      </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <DestinationCard v-for="d in destinations" :key="d.id" :destination="d" />
    </div>
  </section>
</template>
