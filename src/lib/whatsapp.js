// Construye un enlace wa.me con el número configurado y un mensaje opcional.
export function whatsappLink(number, text = 'Hola Wanderly, quiero información sobre sus viajes') {
  const clean = (number || '').replace(/\D/g, '')
  return `https://wa.me/${clean}?text=${encodeURIComponent(text)}`
}
