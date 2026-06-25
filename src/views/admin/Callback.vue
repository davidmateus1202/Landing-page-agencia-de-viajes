<script setup>
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const route = useRoute()
const router = useRouter()
const auth = useAuthStore()

onMounted(async () => {
  const token = route.query.token
  if (token) {
    auth.setToken(token)
    await auth.fetchUser()
    router.replace('/admin')
  } else {
    router.replace({ name: 'admin-login', query: { error: route.query.error || 'auth_failed' } })
  }
})
</script>

<template>
  <div class="min-h-screen bg-brand-50 flex items-center justify-center">
    <p class="text-brand-700 font-medium">Iniciando sesión…</p>
  </div>
</template>
