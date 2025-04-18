<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
    ];
    // Relasi dengan model Mobil
    public function mobil()
    {
        return $this->hasMany(Mobil::class, 'jenis_id', 'id');
    }
}
