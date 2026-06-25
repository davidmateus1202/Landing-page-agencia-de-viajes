<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /** Public: list active plans / promotions. */
    public function index()
    {
        return Plan::where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    /** Admin: list all plans. */
    public function all()
    {
        return Plan::orderBy('order')->get();
    }

    public function store(Request $request)
    {
        return response()->json(Plan::create($this->validateData($request)), 201);
    }

    public function show(Plan $plan)
    {
        return $plan;
    }

    public function update(Request $request, Plan $plan)
    {
        $plan->update($this->validateData($request));

        return $plan;
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->noContent();
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'valid_from' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
            'image' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);
    }
}
