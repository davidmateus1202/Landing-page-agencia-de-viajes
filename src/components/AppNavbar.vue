<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { IconPlane, IconPhone, IconUser, IconMenu2 } from '@tabler/icons-vue'
import { scrollToId } from '../lib/scroll'

const props = defineProps({ settings: { type: Object, default: () => ({}) } })

const router = useRouter()
const scrolled = ref(false)
const open = ref(false)

// Cada enlace apunta a la sección correspondiente (null = ir arriba del todo).
const links = [
  { label: 'Home', target: null },
  { label: 'Destinations', target: 'destinos' },
  { label: 'Tours', target: 'planes' },
  { label: 'Flights', target: 'buscador' },
  { label: 'Hotels', target: 'buscador' },
  { label: 'Blog', target: 'contacto' },
  { label: 'About Us', target: 'porque' },
]

function go(target) {
  open.value = false
  scrollToId(target)
}

function onScroll() {
  scrolled.value = window.scrollY > 40
}
onMounted(() => window.addEventListener('scroll', onScroll))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<template>
  <header
    class="fixed top-0 inset-x-0 z-50 transition-colors duration-300"
    :class="scrolled ? 'glass shadow-sm' : 'bg-transparent'"
  >
    <nav class="max-w-7xl mx-auto px-5 lg:px-8 h-20 flex items-center justify-between">
      <!-- Logo -->
      <button class="flex items-center gap-2" @click="go(null)">
        <span class="logo-plane inline-flex items-center justify-center w-9 h-9 rounded-lg bg-brand-500 text-white">
          <IconPlane :size="20" stroke="{2}" />
        </span>
        <span class="leading-tight text-left">
          <span class="block text-xl font-extrabold text-brand-700">Wanderly</span>
          <span class="block text-[10px] tracking-[0.25em] text-muted font-semibold">TRAVEL THE WORLD</span>
        </span>
      </button>

      <!-- Links -->
      <ul class="hidden lg:flex items-center gap-7 text-sm font-medium text-ink/80">
        <li v-for="(link, i) in links" :key="link.label">
          <button
            class="hover:text-brand-600 transition-colors cursor-pointer"
            :class="i === 0 ? 'text-brand-600 font-semibold border-b-2 border-brand-500 pb-1' : ''"
            @click="go(link.target)"
          >{{ link.label }}</button>
        </li>
      </ul>

      <!-- Right -->
      <div class="flex items-center gap-4">
        <a :href="`tel:${(settings.phone || '').replace(/\\s/g, '')}`" class="hidden md:flex items-center gap-2 group">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-brand-50 text-brand-600 group-hover:bg-brand-100 transition-colors">
            <IconPhone :size="18" />
          </span>
          <span class="leading-tight text-xs text-left">
            <span class="block text-muted">Need Help?</span>
            <span class="block font-semibold text-ink">{{ settings.phone || '+1 234 567 8900' }}</span>
          </span>
        </a>
        <button
          class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-500 text-white hover:bg-brand-600 transition-colors"
          title="Panel admin"
          @click="router.push('/admin/login')"
        >
          <IconUser :size="18" />
        </button>
        <button class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg bg-brand-50 text-brand-600" @click="open = !open">
          <IconMenu2 :size="20" />
        </button>
      </div>
    </nav>

    <!-- Mobile menu -->
    <div v-if="open" class="lg:hidden glass border-t border-white/40 px-5 py-4">
      <ul class="flex flex-col gap-3 text-sm font-medium">
        <li v-for="link in links" :key="link.label">
          <button class="block py-1 w-full text-left" @click="go(link.target)">{{ link.label }}</button>
        </li>
      </ul>
    </div>
  </header>
</template>
