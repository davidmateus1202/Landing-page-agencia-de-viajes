<script setup>
import { ref } from 'vue'
import {
  IconSend, IconBrandFacebook, IconBrandInstagram,
  IconBrandX, IconBrandYoutube,
} from '@tabler/icons-vue'
import api from '../lib/api'

const props = defineProps({ settings: { type: Object, default: () => ({}) } })

const email = ref('')
const status = ref(null)

const socials = [
  { key: 'social_facebook', icon: IconBrandFacebook },
  { key: 'social_instagram', icon: IconBrandInstagram },
  { key: 'social_twitter', icon: IconBrandX },
  { key: 'social_youtube', icon: IconBrandYoutube },
]

async function subscribe() {
  if (!email.value) return
  status.value = 'loading'
  try {
    await api.post('/subscribe', { email: email.value })
    status.value = 'ok'
    email.value = ''
  } catch {
    status.value = 'error'
  }
}
</script>

<template>
  <footer class="bg-brand-600 text-white mt-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-12">
      <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
        <!-- Newsletter -->
        <div class="flex items-start gap-4 max-w-md">
          <span class="shrink-0 inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white/15">
            <IconSend :size="22" />
          </span>
          <div>
            <h3 class="font-bold text-lg">Subscribe to Our Newsletter</h3>
            <p class="text-sm text-white/80 mt-1">Get the latest travel deals and inspiration straight to your inbox.</p>
          </div>
        </div>

        <!-- Form -->
        <form class="flex w-full max-w-md bg-white rounded-full p-1.5" @submit.prevent="subscribe">
          <input
            v-model="email"
            type="email"
            required
            placeholder="Enter your email"
            class="flex-1 px-4 text-sm text-ink outline-none bg-transparent"
          />
          <button class="bg-brand-500 hover:bg-brand-700 text-white text-sm font-semibold px-6 py-2.5 rounded-full transition-colors">
            {{ status === 'loading' ? '...' : 'Subscribe' }}
          </button>
        </form>

        <!-- Redes -->
        <div class="flex items-center gap-3">
          <a
            v-for="s in socials"
            :key="s.key"
            :href="settings[s.key] || '#'"
            target="_blank"
            rel="noopener"
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/15 hover:bg-white/25 transition-colors"
          >
            <component :is="s.icon" :size="18" />
          </a>
        </div>
      </div>

      <p v-if="status === 'ok'" class="text-center text-sm text-white/90 mt-6">¡Gracias por suscribirte! 🎉</p>
      <p v-if="status === 'error'" class="text-center text-sm text-white/90 mt-6">Hubo un problema. Intenta de nuevo.</p>

      <div class="border-t border-white/15 mt-10 pt-6 text-center text-xs text-white/70">
        © 2026 Wanderly. Travel the World.
      </div>
    </div>
  </footer>
</template>
