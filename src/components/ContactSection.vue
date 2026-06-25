<script setup>
import { ref } from 'vue'
import { IconMail, IconBrandWhatsapp, IconSend } from '@tabler/icons-vue'
import api from '../lib/api'
import { whatsappLink } from '../lib/whatsapp'

const props = defineProps({ settings: { type: Object, default: () => ({}) } })

const form = ref({ name: '', email: '', message: '' })
const status = ref(null)

async function send() {
  status.value = 'loading'
  try {
    await api.post('/contact', form.value)
    status.value = 'ok'
    form.value = { name: '', email: '', message: '' }
  } catch {
    status.value = 'error'
  }
}
</script>

<template>
  <section id="contacto" class="max-w-7xl mx-auto px-5 lg:px-8 mt-24 scroll-mt-28">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
      <!-- Canales -->
      <div class="reveal">
        <span class="text-xs font-semibold tracking-widest text-brand-500">CONTACTO</span>
        <h2 class="text-3xl font-extrabold text-brand-900 mt-2">¿Hablamos de tu próximo viaje?</h2>
        <p class="text-muted text-sm mt-3 max-w-md">Escríbenos por el canal que prefieras. Te respondemos rápido.</p>

        <div class="mt-8 space-y-4">
          <a
            :href="whatsappLink(settings.whatsapp_number, 'Hola Wanderly, quiero información')"
            target="_blank" rel="noopener"
            class="glass flex items-center gap-4 p-4 rounded-xl hover:bg-brand-50 transition-colors"
          >
            <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-brand-50 text-brand-600"><IconBrandWhatsapp :size="22" /></span>
            <span>
              <span class="block text-xs text-muted">WhatsApp</span>
              <span class="block font-semibold text-ink text-sm">{{ settings.phone || settings.whatsapp_number }}</span>
            </span>
          </a>
          <a
            :href="`mailto:${settings.contact_email}`"
            class="glass flex items-center gap-4 p-4 rounded-xl hover:bg-brand-50 transition-colors"
          >
            <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-brand-50 text-brand-600"><IconMail :size="22" /></span>
            <span>
              <span class="block text-xs text-muted">Correo</span>
              <span class="block font-semibold text-ink text-sm">{{ settings.contact_email }}</span>
            </span>
          </a>
        </div>
      </div>

      <!-- Formulario -->
      <form class="reveal glass rounded-2xl p-6 lg:p-8" @submit.prevent="send">
        <h3 class="font-bold text-lg text-brand-900 mb-4">Envíanos un mensaje</h3>
        <div class="space-y-3">
          <input v-model="form.name" required placeholder="Tu nombre" class="w-full bg-white rounded-xl px-4 py-3 text-sm outline-none" />
          <input v-model="form.email" required type="email" placeholder="Tu correo" class="w-full bg-white rounded-xl px-4 py-3 text-sm outline-none" />
          <textarea v-model="form.message" required rows="4" placeholder="¿En qué te ayudamos?" class="w-full bg-white rounded-xl px-4 py-3 text-sm outline-none resize-none"></textarea>
        </div>
        <button class="mt-4 w-full inline-flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
          <IconSend :size="18" /> {{ status === 'loading' ? 'Enviando...' : 'Enviar mensaje' }}
        </button>
        <p v-if="status === 'ok'" class="text-sm text-brand-600 mt-3 text-center">¡Mensaje enviado! Te contactaremos pronto.</p>
        <p v-if="status === 'error'" class="text-sm text-red-500 mt-3 text-center">No se pudo enviar. Intenta de nuevo.</p>
      </form>
    </div>
  </section>
</template>
