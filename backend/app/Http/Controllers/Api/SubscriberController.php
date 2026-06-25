<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /** Public: newsletter sign up. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        Subscriber::firstOrCreate(['email' => $data['email']]);

        return response()->json([
            'message' => '¡Suscripción exitosa!',
        ], 201);
    }

    /** Admin: list subscribers. */
    public function index()
    {
        return Subscriber::latest()->get();
    }
}
