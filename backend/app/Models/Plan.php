<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'title', 'description', 'price', 'valid_from', 'valid_until', 'image', 'is_active', 'order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];
}
