import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

const reduceMotion =
  typeof window !== 'undefined' &&
  window.matchMedia('(prefers-reduced-motion: reduce)').matches

/**
 * Revela elementos al hacer scroll (fade + desplazamiento).
 * @param {string} selector  selector dentro del scope
 * @param {Element} scope    elemento contenedor
 */
export function revealOnScroll(selector, scope) {
  if (reduceMotion) return
  const els = scope.querySelectorAll(selector)
  els.forEach((el) => {
    gsap.from(el, {
      scrollTrigger: { trigger: el, start: 'top 85%' },
      y: 40,
      opacity: 0,
      duration: 0.8,
      ease: 'power3.out',
    })
  })
}

/**
 * Revela en cascada (stagger) un grupo de elementos hijos.
 */
export function staggerReveal(selector, scope, opts = {}) {
  if (reduceMotion) return
  const els = scope.querySelectorAll(selector)
  if (!els.length) return
  gsap.from(els, {
    scrollTrigger: { trigger: els[0], start: 'top 85%' },
    y: 50,
    opacity: 0,
    duration: 0.7,
    stagger: 0.15,
    ease: 'power3.out',
  })
}

export { gsap, reduceMotion }
