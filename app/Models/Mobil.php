<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'name',
        'brand',
        'year',
        'quantity',
        'jenis_id',
    ];

    /**
     * Relasi ke model Jenis
     */
    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }
}
