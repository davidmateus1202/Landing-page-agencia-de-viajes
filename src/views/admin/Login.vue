<script setup>
import { useRoute } from 'vue-router'
import { computed } from 'vue'
import { IconBrandGoogle, IconPlane } from '@tabler/icons-vue'
import { useAuthStore } from '../../stores/auth'

const auth = useAuthStore()
const route = useRoute()

const error = computed(() => {
  if (route.query.error === 'not_authorized') return 'Tu cuenta no está autorizada como administrador.'
  if (route.query.error) return 'No se pudo iniciar sesión. Intenta de nuevo.'
  return null
})
</script>

<template>
  <div class="min-h-screen bg-brand-50 flex items-center justify-center px-5">
    <div class="glass rounded-2xl p-10 w-full max-w-md text-center">
      <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-brand-500 text-white mb-5">
        <IconPlane :size="28" />
      </span>
      <h1 class="text-2xl font-extrabold text-brand-900">Panel Wanderly</h1>
      <p class="text-sm text-muted mt-2">Inicia sesión para administrar el contenido.</p>

      <p v-if="error" class="mt-5 text-sm text-red-500 bg-red-50 rounded-lg py-2 px-3">{{ error }}</p>

      <a
        :href="auth.googleLoginUrl"
        class="mt-7 w-full inline-flex items-center justify-center gap-3 bg-white border border-brand-100 hover:bg-brand-50 text-ink font-semibold px-6 py-3.5 rounded-xl transition-colors"
      >
        <IconBrandGoogle :size="20" class="text-brand-600" /> Iniciar sesión con Google
      </a>

      <a href="/" class="block mt-6 text-xs text-muted hover:text-brand-600">← Volver al inicio</a>
    </div>
  </div>
</template>
