<script setup>
import { onMounted, ref } from 'vue'
import { IconPlane } from '@tabler/icons-vue'
import { gsap, reduceMotion } from '../lib/gsap'

const emit = defineEmits(['done'])
const root = ref(null)
const hidden = ref(false)

onMounted(() => {
  if (reduceMotion) {
    hidden.value = true
    emit('done')
    return
  }

  const tl = gsap.timeline({
    defaults: { ease: 'power3.out' },
    onComplete: () => {
      hidden.value = true
      emit('done')
    },
  })

  tl.from('.intro-logo', { scale: 0.6, opacity: 0, duration: 0.5 })
    .from('.intro-name', { y: 20, opacity: 0, duration: 0.5 }, '-=0.2')
    .to('.intro-plane', { x: 180, y: -120, rotate: 12, duration: 0.9, ease: 'power2.in' }, '+=0.15')
    .to('.intro-name', { opacity: 0, duration: 0.3 }, '-=0.3')
    .to(root.value, { yPercent: -100, duration: 0.7, ease: 'power4.inOut' }, '-=0.1')
})
</script>

<template>
  <div
    v-show="!hidden"
    ref="root"
    class="fixed inset-0 z-[100] bg-brand-600 flex flex-col items-center justify-center text-white overflow-hidden"
  >
    <div class="intro-logo inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white/15 mb-5">
      <IconPlane class="intro-plane" :size="44" />
    </div>
    <div class="intro-name text-center">
      <p class="text-3xl font-extrabold tracking-tight">Wanderly</p>
      <p class="text-[11px] tracking-[0.35em] text-white/70 mt-1">TRAVEL THE WORLD</p>
    </div>
  </div>
</template>
