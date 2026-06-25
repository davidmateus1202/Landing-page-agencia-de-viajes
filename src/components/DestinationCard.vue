<script setup>
import { computed } from 'vue'
import { IconMapPin } from '@tabler/icons-vue'
import { useContentStore } from '../stores/content'
import { whatsappLink } from '../lib/whatsapp'

const props = defineProps({ destination: { type: Object, required: true } })
const content = useContentStore()

const badgeLabel = computed(() => {
  const map = { bestseller: 'Bestseller', popular: 'Popular', trending: 'Trending' }
  return map[props.destination.badge] || null
})

function book() {
  const d = props.destination
  const msg = `Hola Wanderly, me interesa el destino ${d.name} (${d.location}) desde $${Math.round(d.price)}. ¿Me dan más info?`
  window.open(whatsappLink(content.settings.whatsapp_number, msg), '_blank')
}
</script>

<template>
  <article class="destination-card group relative rounded-2xl overflow-hidden h-80 cursor-pointer" @click="book">
    <img
      :src="destination.image"
      :alt="destination.name"
      class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
    />
    <!-- velo sólido inferior (sin degradado fuerte) -->
    <div class="absolute inset-0 bg-brand-900/10"></div>
    <div class="absolute bottom-0 inset-x-0 h-1/2 bg-brand-900/45"></div>

    <span
      v-if="badgeLabel"
      class="absolute top-3 left-3 glass text-brand-700 text-xs font-semibold px-3 py-1 rounded-full"
    >{{ badgeLabel }}</span>

    <div class="absolute bottom-0 inset-x-0 p-4 text-white flex items-end justify-between">
      <div>
        <h3 class="font-bold text-lg leading-tight">{{ destination.name }}</h3>
        <p class="flex items-center gap-1 text-xs text-white/85 mt-1">
          <IconMapPin :size="14" /> {{ destination.location }}
        </p>
      </div>
      <div class="text-right">
        <span class="block text-[10px] text-white/75">From</span>
        <span class="font-bold text-lg">${{ Math.round(destination.price) }}</span>
      </div>
    </div>
  </article>
</template>
