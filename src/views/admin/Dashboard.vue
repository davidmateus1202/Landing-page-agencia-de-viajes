<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import {
  IconPlane, IconMapPin, IconTag, IconSettings, IconMail,
  IconLogout, IconTrash, IconEdit, IconPlus, IconX,
} from '@tabler/icons-vue'
import api from '../../lib/api'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const tabs = [
  { key: 'destinations', label: 'Destinos', icon: IconMapPin },
  { key: 'plans', label: 'Planes', icon: IconTag },
  { key: 'settings', label: 'Canales', icon: IconSettings },
  { key: 'messages', label: 'Mensajes', icon: IconMail },
]
const active = ref('destinations')

const destinations = ref([])
const plans = ref([])
const settings = ref({})
const messages = ref([])

const editing = ref(null) // objeto en edición (destino o plan)
const editType = ref(null)

async function loadAll() {
  const [d, p, s, m] = await Promise.all([
    api.get('/admin/destinations'),
    api.get('/admin/plans'),
    api.get('/admin/settings'),
    api.get('/admin/messages'),
  ])
  destinations.value = d.data
  plans.value = p.data
  settings.value = s.data
  messages.value = m.data
}

function newDestination() {
  editType.value = 'destination'
  editing.value = { name: '', location: '', price: 0, badge: 'popular', image: '', is_active: true, order: 0 }
}
function newPlan() {
  editType.value = 'plan'
  editing.value = { title: '', description: '', price: 0, valid_until: '', image: '', is_active: true, order: 0 }
}
function edit(item, type) {
  editType.value = type
  editing.value = { ...item }
}
function closeEditor() {
  editing.value = null
  editType.value = null
}

async function save() {
  const isDest = editType.value === 'destination'
  const base = isDest ? '/admin/destinations' : '/admin/plans'
  if (editing.value.id) {
    await api.put(`${base}/${editing.value.id}`, editing.value)
  } else {
    await api.post(base, editing.value)
  }
  closeEditor()
  await loadAll()
}

async function remove(item, type) {
  if (!confirm('¿Eliminar este elemento?')) return
  const base = type === 'destination' ? '/admin/destinations' : '/admin/plans'
  await api.delete(`${base}/${item.id}`)
  await loadAll()
}

async function saveSettings() {
  await api.put('/admin/settings', settings.value)
  alert('Canales actualizados.')
}

async function deleteMessage(m) {
  await api.delete(`/admin/messages/${m.id}`)
  await loadAll()
}

async function logout() {
  await auth.logout()
  router.push('/admin/login')
}

onMounted(async () => {
  await auth.fetchUser()
  if (!auth.token) return router.push('/admin/login')
  try {
    await loadAll()
  } catch {
    router.push('/admin/login')
  }
})
</script>

<template>
  <div class="min-h-screen bg-brand-50">
    <!-- Topbar -->
    <header class="bg-white border-b border-brand-100">
      <div class="max-w-6xl mx-auto px-5 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-brand-500 text-white"><IconPlane :size="18" /></span>
          <span class="font-extrabold text-brand-700">Wanderly <span class="text-muted font-medium text-sm">· Admin</span></span>
        </div>
        <div class="flex items-center gap-3">
          <span v-if="auth.user" class="text-sm text-muted hidden sm:block">{{ auth.user.email }}</span>
          <button class="inline-flex items-center gap-1 text-sm text-red-500 hover:text-red-600" @click="logout">
            <IconLogout :size="16" /> Salir
          </button>
        </div>
      </div>
    </header>

    <div class="max-w-6xl mx-auto px-5 py-8">
      <!-- Tabs -->
      <div class="flex flex-wrap gap-2 mb-6">
        <button
          v-for="t in tabs" :key="t.key"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-colors"
          :class="active === t.key ? 'bg-brand-500 text-white' : 'bg-white text-ink/70 hover:bg-brand-100'"
          @click="active = t.key"
        >
          <component :is="t.icon" :size="16" /> {{ t.label }}
        </button>
      </div>

      <!-- DESTINOS -->
      <section v-if="active === 'destinations'">
        <div class="flex justify-between items-center mb-4">
          <h2 class="font-bold text-lg text-brand-900">Destinos populares</h2>
          <button class="inline-flex items-center gap-1 bg-brand-500 text-white text-sm font-semibold px-4 py-2 rounded-lg" @click="newDestination">
            <IconPlus :size="16" /> Nuevo
          </button>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="d in destinations" :key="d.id" class="bg-white rounded-xl overflow-hidden">
            <img :src="d.image" class="h-32 w-full object-cover" />
            <div class="p-4">
              <div class="flex justify-between">
                <h3 class="font-semibold">{{ d.name }}</h3>
                <span class="text-brand-600 font-bold">${{ Math.round(d.price) }}</span>
              </div>
              <p class="text-xs text-muted">{{ d.location }} · {{ d.badge }}</p>
              <div class="flex gap-2 mt-3">
                <button class="text-brand-600 text-sm inline-flex items-center gap-1" @click="edit(d, 'destination')"><IconEdit :size="15" /> Editar</button>
                <button class="text-red-500 text-sm inline-flex items-center gap-1" @click="remove(d, 'destination')"><IconTrash :size="15" /> Eliminar</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- PLANES -->
      <section v-if="active === 'plans'">
        <div class="flex justify-between items-center mb-4">
          <h2 class="font-bold text-lg text-brand-900">Planes / Promociones</h2>
          <button class="inline-flex items-center gap-1 bg-brand-500 text-white text-sm font-semibold px-4 py-2 rounded-lg" @click="newPlan">
            <IconPlus :size="16" /> Nuevo
          </button>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="p in plans" :key="p.id" class="bg-white rounded-xl overflow-hidden">
            <img :src="p.image" class="h-32 w-full object-cover" />
            <div class="p-4">
              <div class="flex justify-between">
                <h3 class="font-semibold">{{ p.title }}</h3>
                <span class="text-brand-600 font-bold">${{ Math.round(p.price) }}</span>
              </div>
              <p class="text-xs text-muted line-clamp-2">{{ p.description }}</p>
              <div class="flex gap-2 mt-3">
                <button class="text-brand-600 text-sm inline-flex items-center gap-1" @click="edit(p, 'plan')"><IconEdit :size="15" /> Editar</button>
                <button class="text-red-500 text-sm inline-flex items-center gap-1" @click="remove(p, 'plan')"><IconTrash :size="15" /> Eliminar</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CANALES -->
      <section v-if="active === 'settings'" class="bg-white rounded-xl p-6 max-w-2xl">
        <h2 class="font-bold text-lg text-brand-900 mb-4">Canales de atención y redes</h2>
        <div class="grid sm:grid-cols-2 gap-4">
          <label class="block"><span class="text-xs text-muted">WhatsApp</span><input v-model="settings.whatsapp_number" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm mt-1" /></label>
          <label class="block"><span class="text-xs text-muted">Teléfono</span><input v-model="settings.phone" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm mt-1" /></label>
          <label class="block"><span class="text-xs text-muted">Correo</span><input v-model="settings.contact_email" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm mt-1" /></label>
          <label class="block"><span class="text-xs text-muted">Facebook</span><input v-model="settings.social_facebook" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm mt-1" /></label>
          <label class="block"><span class="text-xs text-muted">Instagram</span><input v-model="settings.social_instagram" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm mt-1" /></label>
          <label class="block"><span class="text-xs text-muted">Twitter / X</span><input v-model="settings.social_twitter" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm mt-1" /></label>
          <label class="block"><span class="text-xs text-muted">YouTube</span><input v-model="settings.social_youtube" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm mt-1" /></label>
        </div>
        <button class="mt-5 bg-brand-500 text-white text-sm font-semibold px-5 py-2.5 rounded-lg" @click="saveSettings">Guardar cambios</button>
      </section>

      <!-- MENSAJES -->
      <section v-if="active === 'messages'">
        <h2 class="font-bold text-lg text-brand-900 mb-4">Mensajes de contacto</h2>
        <div v-if="!messages.length" class="text-muted text-sm">Sin mensajes todavía.</div>
        <div v-for="m in messages" :key="m.id" class="bg-white rounded-xl p-4 mb-3">
          <div class="flex justify-between">
            <div>
              <h3 class="font-semibold text-sm">{{ m.name }} <span class="text-muted font-normal">· {{ m.email }}</span></h3>
              <p class="text-sm text-ink/80 mt-1">{{ m.message }}</p>
            </div>
            <button class="text-red-500" @click="deleteMessage(m)"><IconTrash :size="16" /></button>
          </div>
        </div>
      </section>
    </div>

    <!-- Editor modal -->
    <div v-if="editing" class="fixed inset-0 z-50 bg-brand-900/50 flex items-center justify-center p-5" @click.self="closeEditor">
      <div class="bg-white rounded-2xl p-6 w-full max-w-lg max-h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-bold text-lg">{{ editing.id ? 'Editar' : 'Nuevo' }} {{ editType === 'destination' ? 'destino' : 'plan' }}</h3>
          <button @click="closeEditor"><IconX :size="20" /></button>
        </div>

        <div class="space-y-3">
          <template v-if="editType === 'destination'">
            <input v-model="editing.name" placeholder="Nombre" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm" />
            <input v-model="editing.location" placeholder="Ubicación" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm" />
            <input v-model.number="editing.price" type="number" placeholder="Precio" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm" />
            <select v-model="editing.badge" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm">
              <option value="bestseller">Bestseller</option>
              <option value="popular">Popular</option>
              <option value="trending">Trending</option>
            </select>
          </template>
          <template v-else>
            <input v-model="editing.title" placeholder="Título" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm" />
            <textarea v-model="editing.description" placeholder="Descripción" rows="3" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm"></textarea>
            <input v-model.number="editing.price" type="number" placeholder="Precio" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm" />
            <input v-model="editing.valid_until" type="date" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm" />
          </template>
          <input v-model="editing.image" placeholder="URL de imagen" class="w-full bg-brand-50 rounded-lg px-3 py-2 text-sm" />
          <label class="flex items-center gap-2 text-sm"><input v-model="editing.is_active" type="checkbox" /> Activo</label>
        </div>

        <div class="flex gap-2 mt-5">
          <button class="flex-1 bg-brand-500 text-white font-semibold py-2.5 rounded-lg" @click="save">Guardar</button>
          <button class="px-5 bg-brand-50 rounded-lg" @click="closeEditor">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</template>
