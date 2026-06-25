# Wanderly — Landing Page de Agencia de Viajes

Instrucciones técnicas y de diseño para construir el proyecto. Documento de referencia para el equipo (o para Claude Code) que desarrolle la aplicación.

---

## 1. Resumen del proyecto

Sitio web para una agencia de viajes llamada **Wanderly** ("Travel the World"). Consta de:

- **Landing page pública** fiel al diseño propuesto (ver `desing.jpg`).
- **Panel administrativo** para gestionar el contenido (destinos, planes/promociones, canales de atención, etc.).
- **Backend con API + base de datos MySQL** que alimenta tanto la landing como el panel.
- **Autenticación social** en el panel admin (login con redes sociales).
- **Canales de atención**: WhatsApp, correo y redes sociales.

> El objetivo principal es que el diseño quede **lo más apegado posible a la imagen** `desing.jpg`.

---

## 2. Stack tecnológico

| Capa | Tecnología |
|------|-----------|
| Frontend | **Vue 3** (Composition API + `<script setup>`) + Vite |
| Estilos | **Tailwind CSS** |
| Iconos | **Tabler Icons** (`@tabler/icons-vue`) |
| Animaciones | **GSAP** (+ ScrollTrigger) |
| Backend | **Laravel** (PHP) |
| Base de datos | **MySQL** |
| Auth social | **Laravel Socialite** (solo Google) |
| API | REST con Laravel Sanctum para sesión del panel admin |

### Dependencias clave

**Frontend**
```bash
npm install vue@latest
npm install -D tailwindcss postcss autoprefixer vite
npm install @tabler/icons-vue
npm install gsap
npm install axios pinia vue-router
```

**Backend**
```bash
composer create-project laravel/laravel backend
composer require laravel/socialite
composer require laravel/sanctum
```

---

## 3. Lineamientos de diseño (MUY IMPORTANTE)

El diseño debe replicar `desing.jpg`. Reglas globales:

- **Paleta azul con colores sólidos.** Evitar degradados. Usar fondos planos.
- **Componentes "glass" (glassmorphism)** para dar aire moderno: paneles semitransparentes con desenfoque (`backdrop-blur`), borde sutil y sombra ligera. Usar especialmente en la barra de búsqueda y en tarjetas superpuestas sobre imágenes.
- **Evitar bordes muy redondeados.** Usar esquinas suaves pero discretas (`rounded-lg` / `rounded-xl` como máximo en tarjetas; nada de `rounded-3xl` o `rounded-full` excepto botones tipo "pill" y avatares).
- **Sin contornos marcados.** Bordes muy finos y de bajo contraste, o ninguno. Apoyarse en sombras suaves para separar elementos.
- Tipografía limpia tipo sans-serif (ej. *Poppins* o *Inter*). El título del hero combina un peso bold negro ("Discover Amazing") con un estilo script/itálico azul ("Places with Us").

### Paleta de colores sugerida

```css
:root {
  --blue-900: #0B2A4A;  /* azul muy oscuro - textos fuertes */
  --blue-700: #14529E;  /* azul medio */
  --blue-600: #1E6FD8;  /* azul principal / botones */
  --blue-500: #2F84E0;  /* azul brillante / acentos */
  --blue-100: #E8F1FB;  /* azul muy claro - fondos de iconos */
  --white:    #FFFFFF;
  --gray-700: #3A4451;  /* texto secundario */
  --gray-400: #94A3B8;  /* texto tenue / placeholders */
  --gray-50:  #F6F8FB;  /* fondos de sección */
}
```

Configurar estos colores en `tailwind.config.js` bajo `theme.extend.colors`.

### Estilo glass (Tailwind utilitario)

```html
<div class="bg-white/70 backdrop-blur-md border border-white/40 shadow-lg rounded-xl">
  ...
</div>
```

---

## 4. Estructura de la landing page (secciones)

Replicar de arriba hacia abajo según `desing.jpg`:

### 4.1 Header / Navbar
- Logo **Wanderly** con ícono de avión + subtítulo "TRAVEL THE WORLD".
- Navegación: `Home`, `Destinations`, `Tours`, `Flights`, `Hotels`, `Blog`, `About Us`.
- Bloque derecho: ícono de teléfono + "Need Help? +1 234 567 8900" y un ícono de usuario (circular) que lleva al login del admin.
- Item activo (`Home`) subrayado en azul.
- Navbar transparente sobre el hero, con efecto glass al hacer scroll (opcional).

### 4.2 Hero
- Fondo: imagen de **Santorini** (cúpulas azules) ocupando la mitad derecha.
- Etiqueta superior: "✈ EXPLORE. DREAM. DISCOVER." en una píldora glass.
- Título: **"Discover Amazing"** (negro, bold) + **"Places with Us"** (script azul).
- Párrafo descriptivo corto.
- Botón sólido azul tipo pill: **"Explore Now →"**.

### 4.3 Barra de búsqueda (glass, superpuesta)
- Panel blanco/glass con esquinas suaves, superpuesto entre hero y contenido.
- Tabs: **Flights** (activo), **Hotels**, **Tours**, **Packages** — cada uno con su ícono Tabler.
- Campos: `From` (New York NYC), `To` (Where to?), `Depart` (fecha), `Return` (fecha), `Travelers` (2 Adults, 1 Child).
- Botón sólido azul: **"Search 🔍"**.

### 4.4 Franja de beneficios (4 columnas)
Cada uno con ícono en círculo azul claro:
- **Best Price Guarantee** — "We ensure you get the best deals always."
- **24/7 Customer Support** — "We're here to help you anytime, anywhere."
- **Secure Bookings** — "Your data and payments are 100% safe with us."
- **Handpicked Experiences** — "Curated tours and hotels for unforgettable trips."

### 4.5 Popular Destinations (sección dinámica — admin)
- Título "Popular Destinations" + botón pill "View All Destinations →".
- 4 tarjetas con imagen, badge (Bestseller / Popular / Trending), nombre del destino, ubicación con ícono de pin y precio "From $XXX".
  - Thailand — Phuket — $699 — Bestseller
  - France — Paris — $799 — Popular
  - Bali, Indonesia — Ubud — $599 — Trending
  - Dubai, UAE — Dubai — $899 — Bestseller
- El texto va sobre la imagen, en la parte inferior, con un velo oscuro sólido (no degradado fuerte).
- **Esta sección se administra desde el panel** (CRUD de destinos).

### 4.6 Why Choose Wanderly?
- Título "Why Choose **Wanderly?**".
- 4 features en 2 columnas con íconos: Wide Range of Choices, Trusted by Travelers, Flexible & Easy Booking, Exclusive Deals.
- A la derecha: tarjeta "LET'S GO! — **Your Next Adventure Awaits!**" con imagen de playa y botón pill "Plan Your Trip →".

### 4.7 Sección de Planes / Promociones (admin)
- **Nueva sección administrable.** Mostrar los planes/promociones que el admin cree.
- Tarjetas con nombre del plan, descripción, precio, vigencia y CTA. Mantener estilo glass + azul sólido.

### 4.8 Newsletter / Footer
- Banda azul sólida.
- "Subscribe to Our Newsletter" + input de correo + botón "Subscribe".
- Íconos sociales (Tabler): Facebook, Instagram, Twitter/X, YouTube — enlazados a las redes configuradas por el admin.

---

## 5. Canales de atención

Implementar canales de contacto, configurables desde el panel admin:

- **WhatsApp**: botón flotante fijo (esquina inferior derecha) con ícono Tabler `brand-whatsapp`, que abre `https://wa.me/<numero>?text=<mensaje>`.
- **Correo**: formulario de contacto y/o enlace `mailto:`. Los envíos pueden guardarse en BD y/o reenviarse por email (Laravel Mail).
- **Redes sociales**: enlaces en el footer y en la sección de contacto, tomados de la tabla de configuración.

Todos los valores (número de WhatsApp, correo, URLs de redes) deben venir de la BD para que el admin los edite sin tocar código.

---

## 6. Animaciones (GSAP)

Las animaciones son una prioridad. Usar **GSAP + ScrollTrigger**.

- **Animación de carga inicial (intro):** al cargar la página, una animación que capte la atención. Sugerencia: el avión del logo "vuela" cruzando la pantalla, el título del hero aparece con un reveal escalonado (stagger), y la barra de búsqueda sube con fade. Usar una línea de tiempo (`gsap.timeline()`).
- **Reveal on scroll:** cada sección entra con fade + desplazamiento al hacer scroll (`ScrollTrigger`).
- **Sección de destinos animada:** las imágenes/tarjetas de destinos aparecen con stagger y un efecto parallax suave o carrusel animado. Esta sección debe sentirse "viva".
- **Microinteracciones:** hover en tarjetas (leve escala/elevación), botones, tabs de búsqueda.
- Respetar `prefers-reduced-motion` para accesibilidad.

Ejemplo de intro:
```js
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
gsap.registerPlugin(ScrollTrigger)

const tl = gsap.timeline({ defaults: { ease: 'power3.out' } })
tl.from('.logo-plane', { x: -200, opacity: 0, duration: 1 })
  .from('.hero-title span', { y: 40, opacity: 0, stagger: 0.15 }, '-=0.4')
  .from('.hero-cta', { y: 20, opacity: 0 }, '-=0.3')
  .from('.search-bar', { y: 60, opacity: 0, duration: 0.8 }, '-=0.2')
```

---

## 7. Backend (Laravel + MySQL)

### 7.1 Modelos / tablas principales

- **users** — administradores (login social).
- **destinations** — destinos populares: `name`, `location`, `price`, `badge` (bestseller/popular/trending), `image`, `is_active`, `order`.
- **plans** — planes/promociones: `title`, `description`, `price`, `valid_from`, `valid_until`, `image`, `is_active`.
- **settings** — configuración del sitio: `whatsapp_number`, `contact_email`, `phone`, `social_facebook`, `social_instagram`, `social_twitter`, `social_youtube`. (Tabla clave-valor o fila única.)
- **contact_messages** — mensajes del formulario de contacto: `name`, `email`, `message`, `created_at`.
- **subscribers** — correos del newsletter: `email`.

### 7.2 API REST (públicas)
- `GET /api/destinations` — listar destinos activos.
- `GET /api/plans` — listar planes/promociones activos.
- `GET /api/settings` — canales de atención y redes (solo campos públicos).
- `POST /api/contact` — recibir mensaje de contacto.
- `POST /api/subscribe` — alta en newsletter.

### 7.3 API REST (admin, protegidas con Sanctum)
- CRUD completo: `destinations`, `plans`, `settings`.
- `GET /api/admin/contact-messages` — bandeja de mensajes.

---

## 8. Autenticación social (panel admin)

Usar **Laravel Socialite** con un único proveedor: **Google**.

1. Registrar credenciales OAuth de Google en `.env`:
   ```env
   GOOGLE_CLIENT_ID=xxxxxxxx
   GOOGLE_CLIENT_SECRET=xxxxxxxx
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```
   Configurarlas también en `config/services.php` bajo la clave `google`.
2. Rutas:
   - `GET /auth/google/redirect` → redirige a Google.
   - `GET /auth/google/callback` → recibe el callback, crea/actualiza el usuario y emite token Sanctum.
3. Solo correos en una **lista blanca de administradores** pueden acceder al panel (validar en el callback).
4. El frontend del panel guarda el token y lo envía en `Authorization: Bearer`.

```php
// routes/web.php
Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'callback']);
```

> En el panel solo se muestra el botón **"Iniciar sesión con Google"**.

---

## 9. Panel administrativo (Vue)

Ruta protegida (`/admin`). Permite:

- Login mediante **Google** ("Iniciar sesión con Google").
- **Gestionar destinos** (Popular Destinations): crear, editar, ordenar, activar/desactivar, subir imagen.
- **Gestionar planes/promociones**: CRUD con vigencia.
- **Editar canales de atención**: número de WhatsApp, correo, teléfono y URLs de redes.
- **Ver mensajes de contacto** y suscriptores del newsletter.

Mantener el mismo lenguaje visual: azul sólido, glass, esquinas suaves, iconos Tabler.

---

## 10. Estructura de carpetas sugerida

```
LANDING-PAGE-TRAVEL-AGEND/
├── frontend/                # Vue 3 + Vite
│   ├── src/
│   │   ├── components/      # Navbar, Hero, SearchBar, DestinationCard, PlanCard, WhatsAppButton...
│   │   ├── views/           # Home.vue, admin/*.vue
│   │   ├── composables/     # useGsap.js, useApi.js
│   │   ├── stores/          # Pinia (auth, settings)
│   │   ├── router/
│   │   └── assets/
│   └── tailwind.config.js
├── backend/                 # Laravel
│   ├── app/Models/          # Destination, Plan, Setting, ContactMessage, Subscriber
│   ├── app/Http/Controllers/
│   ├── routes/api.php
│   ├── routes/web.php       # auth social
│   └── database/migrations/
└── INSTRUCCIONES.md
```

---

## 11. Cómo ejecutar el proyecto

### Backend (Laravel) — puerto 8000
```bash
cd backend
# 1) Edita .env con tus credenciales MySQL (DB_USERNAME / DB_PASSWORD)
# 2) Crea la base de datos 'wanderly' y corre migraciones + seeder:
php artisan migrate --seed
# 3) Levanta el servidor:
php artisan serve
```

### Frontend (Vue + Vite) — puerto 5173
```bash
cd frontend
npm run dev
```
Abre http://localhost:5173

### Credenciales de Google (login admin)
1. Crea un proyecto en [Google Cloud Console](https://console.cloud.google.com/) → APIs & Services → Credentials → OAuth client ID (Web).
2. Authorized redirect URI: `http://localhost:8000/auth/google/callback`.
3. Copia Client ID y Secret a `backend/.env` (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`).
4. Define los correos admin en `GOOGLE_ADMIN_EMAILS` (separados por coma).

> El panel admin vive en http://localhost:5173/admin (login en `/admin/login`).

---

## 12. Checklist de implementación

- [ ] Configurar Tailwind con la paleta azul y utilidades glass.
- [ ] Maquetar la landing fiel a `desing.jpg` (header, hero, búsqueda, beneficios, destinos, why choose, planes, footer).
- [ ] Integrar Tabler Icons en todos los íconos.
- [ ] Implementar animación de intro con GSAP.
- [ ] Implementar reveal-on-scroll y sección de destinos animada.
- [ ] Botón flotante de WhatsApp + formulario de contacto + enlaces sociales.
- [ ] Backend Laravel + migraciones MySQL.
- [ ] API pública (destinos, planes, settings, contacto, newsletter).
- [ ] Autenticación social con Socialite + Sanctum + lista blanca de admins.
- [ ] Panel admin con CRUD de destinos, planes y configuración de canales.
- [ ] Verificar accesibilidad (`prefers-reduced-motion`) y responsive.
```
