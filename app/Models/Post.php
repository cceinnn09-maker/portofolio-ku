<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tanggal' => 'date',
        'published' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
