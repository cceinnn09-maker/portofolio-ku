<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar kolom-kolomnya diizinkan untuk diisi
    protected $fillable = [
        'nama_pengirim',
        'email',
        'pesan',
    ];
}