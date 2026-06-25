<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /** Public keys exposed to the landing page. */
    private const PUBLIC_KEYS = [
        'whatsapp_number', 'contact_email', 'phone',
        'social_facebook', 'social_instagram', 'social_twitter', 'social_youtube',
    ];

    /** Public: return only public settings. */
    public function index()
    {
        $all = Setting::allAsArray();

        return collect(self::PUBLIC_KEYS)
            ->mapWithKeys(fn ($key) => [$key => $all[$key] ?? null]);
    }

    /** Admin: return every setting. */
    public function all()
    {
        return Setting::allAsArray();
    }

    /** Admin: update settings. */
    public function update(Request $request)
    {
        $data = $request->validate([
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_twitter' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
        ]);

        Setting::setMany($data);

        return Setting::allAsArray();
    }
}
