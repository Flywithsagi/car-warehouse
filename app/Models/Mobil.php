<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    protected $table = 'mobil';
    // Kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'kode_mobil',
        'name',
        'brand',
        'year',
        'quantity',
        'jenis_id',
    ];

    // Relasi dengan model Jenis
    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }
}
