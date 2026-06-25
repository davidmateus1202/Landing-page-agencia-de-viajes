<script setup>
import { onMounted, ref } from 'vue'
import { IconCalendarEvent, IconArrowRight } from '@tabler/icons-vue'
import { staggerReveal } from '../lib/gsap'
import { useContentStore } from '../stores/content'
import { whatsappLink } from '../lib/whatsapp'

defineProps({ plans: { type: Array, default: () => [] } })
const root = ref(null)
const content = useContentStore()

function book(plan) {
  const price = plan.price ? ` ($${Math.round(plan.price)})` : ''
  const msg = `Hola Wanderly, quiero reservar el plan "${plan.title}"${price}. ¿Me ayudan?`
  window.open(whatsappLink(content.settings.whatsapp_number, msg), '_blank')
}

function fmtDate(d) {
  if (!d) return null
  try {
    return new Date(d).toLocaleDateString('es', { day: '2-digit', month: 'short', year: 'numeric' })
  } catch {
    return d
  }
}

onMounted(() => staggerReveal('.plan-card', root.value))
</script>

<template>
  <section id="planes" ref="root" class="bg-brand-50 mt-24 py-20 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-12">
        <span class="text-xs font-semibold tracking-widest text-brand-500">PROMOCIONES</span>
        <h2 class="text-3xl font-extrabold text-brand-900 mt-2">
          Planes & <span class="font-script text-brand-500 text-4xl">Ofertas</span>
        </h2>
        <p class="text-muted text-sm mt-3">Paquetes seleccionados por nuestro equipo. Administrables desde el panel.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <article
          v-for="p in plans"
          :key="p.id"
          class="plan-card glass rounded-2xl overflow-hidden flex flex-col"
        >
          <div class="relative h-44">
            <img :src="p.image" :alt="p.title" class="w-full h-full object-cover" />
            <span v-if="p.price" class="absolute top-3 right-3 bg-brand-500 text-white text-sm font-bold px-3 py-1 rounded-full">
              ${{ Math.round(p.price) }}
            </span>
          </div>
          <div class="p-5 flex flex-col flex-1">
            <h3 class="font-bold text-lg text-brand-900">{{ p.title }}</h3>
            <p class="text-sm text-muted mt-2 flex-1">{{ p.description }}</p>
            <div class="flex items-center justify-between mt-5">
              <span v-if="p.valid_until" class="flex items-center gap-1 text-xs text-muted">
                <IconCalendarEvent :size="14" /> Hasta {{ fmtDate(p.valid_until) }}
              </span>
              <button class="inline-flex items-center gap-1 text-brand-600 font-semibold text-sm hover:gap-2 transition-all" @click="book(p)">
                Reservar <IconArrowRight :size="15" />
              </button>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>
