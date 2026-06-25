import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../lib/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('wanderly_token'))

  function setToken(value) {
    token.value = value
    if (value) localStorage.setItem('wanderly_token', value)
    else localStorage.removeItem('wanderly_token')
  }

  async function fetchUser() {
    if (!token.value) return null
    try {
      const { data } = await api.get('/admin/me')
      user.value = data
      return data
    } catch (e) {
      setToken(null)
      user.value = null
      return null
    }
  }

  async function logout() {
    try {
      await api.post('/admin/logout')
    } catch (e) {
      // ignore
    }
    setToken(null)
    user.value = null
  }

  // URL del backend para iniciar OAuth con Google.
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const googleLoginUrl = apiBase.replace(/\/api\/?$/, '') + '/auth/google/redirect'

  return { user, token, setToken, fetchUser, logout, googleLoginUrl }
})
