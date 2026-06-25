<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /** Public: list active destinations. */
    public function index()
    {
        return Destination::where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    /** Admin: list all destinations. */
    public function all()
    {
        return Destination::orderBy('order')->get();
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        return response()->json(Destination::create($data), 201);
    }

    public function show(Destination $destination)
    {
        return $destination;
    }

    public function update(Request $request, Destination $destination)
    {
        $destination->update($this->validateData($request, $destination->id));

        return $destination;
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();

        return response()->noContent();
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'badge' => ['nullable', 'in:bestseller,popular,trending'],
            'image' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);
    }
}
