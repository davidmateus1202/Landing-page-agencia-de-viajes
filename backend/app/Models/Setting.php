<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    /**
     * Return all settings as a flat key => value array.
     */
    public static function allAsArray(): array
    {
        return static::query()->pluck('value', 'key')->toArray();
    }

    /**
     * Persist a key => value map of settings.
     */
    public static function setMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
