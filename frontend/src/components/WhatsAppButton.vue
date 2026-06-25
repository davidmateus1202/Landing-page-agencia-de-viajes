<script setup>
import { computed } from 'vue'
import { IconBrandWhatsapp } from '@tabler/icons-vue'

const props = defineProps({ number: { type: String, default: '' } })

const href = computed(() => {
  const clean = (props.number || '').replace(/\D/g, '')
  return `https://wa.me/${clean}?text=${encodeURIComponent('Hola Wanderly, quiero información sobre sus viajes')}`
})
</script>

<template>
  <a
    :href="href"
    target="_blank"
    rel="noopener"
    aria-label="Contactar por WhatsApp"
    class="fixed bottom-6 right-6 z-50 inline-flex items-center justify-center w-14 h-14 rounded-full bg-[#25D366] text-white shadow-xl hover:scale-105 transition-transform"
  >
    <IconBrandWhatsapp :size="28" />
    <span class="absolute inline-flex h-full w-full rounded-full bg-[#25D366] opacity-60 animate-ping -z-10"></span>
  </a>
</template>
