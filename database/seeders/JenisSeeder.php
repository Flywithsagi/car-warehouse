<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jenis;

class JenisSeeder extends Seeder
{
    public function run()
    {
        // Membuat 10 data dummy
        Jenis::factory()->count(10)->create();
    }
}
