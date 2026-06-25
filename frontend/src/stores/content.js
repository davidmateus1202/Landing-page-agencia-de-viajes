import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../lib/api'

// Datos de respaldo (fallback) para que la landing se vea bien aun sin backend.
const FALLBACK_DESTINATIONS = [
  { id: 1, name: 'Thailand', location: 'Phuket', price: 699, badge: 'bestseller', image: 'https://images.unsplash.com/photo-1528181304800-259b08848526?w=800&q=80' },
  { id: 2, name: 'France', location: 'Paris', price: 799, badge: 'popular', image: 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800&q=80' },
  { id: 3, name: 'Bali, Indonesia', location: 'Ubud', price: 599, badge: 'trending', image: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80' },
  { id: 4, name: 'Dubai, UAE', location: 'Dubai', price: 899, badge: 'bestseller', image: 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800&q=80' },
]

const FALLBACK_PLANS = [
  { id: 1, title: 'Escapada de Verano', description: 'Vuelo + hotel 4 noches con desayuno incluido.', price: 749, valid_until: '2026-09-30', image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80' },
  { id: 2, title: 'Aventura en Asia', description: 'Tour guiado por Tailandia y Bali, 10 días.', price: 1299, valid_until: '2026-12-15', image: 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800&q=80' },
  { id: 3, title: 'Luna de Miel Premium', description: 'Paquete todo incluido en destinos paradisíacos.', price: 1899, valid_until: '2027-01-31', image: 'https://images.unsplash.com/photo-1505881502353-a1986add3762?w=800&q=80' },
]

const FALLBACK_SETTINGS = {
  whatsapp_number: '1234567890',
  contact_email: 'hola@wanderly.com',
  phone: '+1 234 567 8900',
  social_facebook: 'https://facebook.com/wanderly',
  social_instagram: 'https://instagram.com/wanderly',
  social_twitter: 'https://twitter.com/wanderly',
  social_youtube: 'https://youtube.com/@wanderly',
}

export const useContentStore = defineStore('content', () => {
  const destinations = ref(FALLBACK_DESTINATIONS)
  const plans = ref(FALLBACK_PLANS)
  const settings = ref(FALLBACK_SETTINGS)

  async function load() {
    try {
      const [d, p, s] = await Promise.all([
        api.get('/destinations'),
        api.get('/plans'),
        api.get('/settings'),
      ])
      if (d.data?.length) destinations.value = d.data
      if (p.data?.length) plans.value = p.data
      if (s.data) settings.value = { ...FALLBACK_SETTINGS, ...s.data }
    } catch (e) {
      // Sin backend disponible: se mantienen los datos de respaldo.
      console.warn('API no disponible, usando datos de respaldo.')
    }
  }

  return { destinations, plans, settings, load }
})
