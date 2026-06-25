<script setup>
import { ref } from 'vue'
import {
  IconPlane, IconBuildingSkyscraper, IconCompass, IconBriefcase,
  IconMapPin, IconCalendar, IconUser, IconSearch,
} from '@tabler/icons-vue'
import { scrollToId } from '../lib/scroll'

const tabs = [
  { key: 'flights', label: 'Flights', icon: IconPlane },
  { key: 'hotels', label: 'Hotels', icon: IconBuildingSkyscraper },
  { key: 'tours', label: 'Tours', icon: IconCompass },
  { key: 'packages', label: 'Packages', icon: IconBriefcase },
]
const active = ref('flights')

function search() {
  scrollToId('destinos')
}
</script>

<template>
  <div id="buscador" class="search-bar pre-anim relative z-20 -mt-28 max-w-6xl mx-auto px-5 lg:px-8 scroll-mt-28">
    <div class="glass rounded-2xl p-3 lg:p-4">
      <!-- Tabs -->
      <div class="flex flex-wrap gap-2 px-1 pb-3">
        <button
          v-for="t in tabs"
          :key="t.key"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-colors"
          :class="active === t.key ? 'bg-brand-500 text-white' : 'text-ink/70 hover:bg-brand-50'"
          @click="active = t.key"
        >
          <component :is="t.icon" :size="16" /> {{ t.label }}
        </button>
      </div>

      <!-- Campos -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-2 items-stretch">
        <div class="lg:col-span-3 bg-white rounded-xl px-4 py-2.5 relative">
          <label class="block text-[11px] text-muted">From</label>
          <input class="w-full text-sm font-medium outline-none" value="New York (NYC)" />
          <IconPlane :size="16" class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-400" />
        </div>
        <div class="lg:col-span-2 bg-white rounded-xl px-4 py-2.5 relative">
          <label class="block text-[11px] text-muted">To</label>
          <input class="w-full text-sm font-medium outline-none" placeholder="Where to?" />
          <IconMapPin :size="16" class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-400" />
        </div>
        <div class="lg:col-span-2 bg-white rounded-xl px-4 py-2.5 relative">
          <label class="block text-[11px] text-muted">Depart</label>
          <input class="w-full text-sm font-medium outline-none" value="May 20, 2026" />
          <IconCalendar :size="16" class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-400" />
        </div>
        <div class="lg:col-span-2 bg-white rounded-xl px-4 py-2.5 relative">
          <label class="block text-[11px] text-muted">Return</label>
          <input class="w-full text-sm font-medium outline-none" value="May 27, 2026" />
          <IconCalendar :size="16" class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-400" />
        </div>
        <div class="lg:col-span-2 bg-white rounded-xl px-4 py-2.5 relative">
          <label class="block text-[11px] text-muted">Travelers</label>
          <input class="w-full text-sm font-medium outline-none" value="2 Adults, 1 Child" />
          <IconUser :size="16" class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-400" />
        </div>
        <button class="lg:col-span-1 bg-brand-500 hover:bg-brand-600 text-white rounded-xl px-4 py-3 flex items-center justify-center gap-2 font-semibold transition-colors" @click="search">
          <IconSearch :size="18" /> <span class="lg:hidden">Search</span>
        </button>
      </div>
    </div>
  </div>
</template>
