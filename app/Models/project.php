<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // tambahkan 'deskripsi' ke dalam array fillable
    protected $fillable = ['nama_project', 'deskripsi', 'gambar'];
}