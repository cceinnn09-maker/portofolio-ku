<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public static function asArray(): array
    {
        return static::query()->pluck('value', 'name')->toArray();
    }
}
