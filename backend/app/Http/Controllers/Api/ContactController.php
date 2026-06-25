<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /** Public: store a contact message. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $message = ContactMessage::create($data);

        return response()->json([
            'message' => '¡Gracias! Tu mensaje fue enviado correctamente.',
            'data' => $message,
        ], 201);
    }

    /** Admin: list messages. */
    public function index()
    {
        return ContactMessage::latest()->get();
    }

    /** Admin: mark as read. */
    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);

        return $message;
    }

    /** Admin: delete a message. */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return response()->noContent();
    }
}
