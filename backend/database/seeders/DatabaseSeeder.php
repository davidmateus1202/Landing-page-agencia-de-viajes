<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Destinos del diseño
        $destinations = [
            ['name' => 'Thailand', 'location' => 'Phuket', 'price' => 699, 'badge' => 'bestseller', 'image' => 'https://images.unsplash.com/photo-1528181304800-259b08848526?w=800&q=80', 'order' => 1],
            ['name' => 'France', 'location' => 'Paris', 'price' => 799, 'badge' => 'popular', 'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800&q=80', 'order' => 2],
            ['name' => 'Bali, Indonesia', 'location' => 'Ubud', 'price' => 599, 'badge' => 'trending', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80', 'order' => 3],
            ['name' => 'Dubai, UAE', 'location' => 'Dubai', 'price' => 899, 'badge' => 'bestseller', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800&q=80', 'order' => 4],
        ];

        foreach ($destinations as $d) {
            Destination::updateOrCreate(['name' => $d['name']], $d);
        }

        // Planes / promociones de ejemplo
        $plans = [
            ['title' => 'Escapada de Verano', 'description' => 'Vuelo + hotel 4 noches con desayuno incluido.', 'price' => 749, 'valid_from' => '2026-06-01', 'valid_until' => '2026-09-30', 'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80', 'order' => 1],
            ['title' => 'Aventura en Asia', 'description' => 'Tour guiado por Tailandia y Bali, 10 días.', 'price' => 1299, 'valid_from' => '2026-07-01', 'valid_until' => '2026-12-15', 'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800&q=80', 'order' => 2],
            ['title' => 'Luna de Miel Premium', 'description' => 'Paquete todo incluido en destinos paradisíacos.', 'price' => 1899, 'valid_from' => '2026-06-15', 'valid_until' => '2027-01-31', 'image' => 'https://images.unsplash.com/photo-1505881502353-a1986add3762?w=800&q=80', 'order' => 3],
        ];

        foreach ($plans as $p) {
            Plan::updateOrCreate(['title' => $p['title']], $p);
        }

        // Canales de atención por defecto
        Setting::setMany([
            'whatsapp_number' => '1234567890',
            'contact_email' => 'hola@wanderly.com',
            'phone' => '+1 234 567 8900',
            'social_facebook' => 'https://facebook.com/wanderly',
            'social_instagram' => 'https://instagram.com/wanderly',
            'social_twitter' => 'https://twitter.com/wanderly',
            'social_youtube' => 'https://youtube.com/@wanderly',
        ]);
    }
}
