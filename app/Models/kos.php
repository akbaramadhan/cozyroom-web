<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kos extends Model
{
    use HasFactory;


    protected $table = 'kos'; // Sesuaikan dengan nama tabel yang benar di dalam database Anda


    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'lokasi',
        'gambar',
        'user_id', // pastikan ada user_id
    ];
}
