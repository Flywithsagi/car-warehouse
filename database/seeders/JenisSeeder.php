<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jenis;

class JenisSeeder extends Seeder
{
    // public function run(): void
    // {
    //     // Generate 10 data dummy menggunakan factory
    //     Jenis::factory()->count(10)->create();
    // }
    public function run(): void
    {
        $data = [
            // Mobil Penumpang
            ['name' => 'Sedan', 'type' => 'Mobil Penumpang'],
            ['name' => 'Hatchback', 'type' => 'Mobil Penumpang'],
            ['name' => 'MPV', 'type' => 'Mobil Penumpang'],
            ['name' => 'SUV', 'type' => 'Mobil Penumpang'],
            ['name' => 'Crossover', 'type' => 'Mobil Penumpang'],
            ['name' => 'Coupe', 'type' => 'Mobil Penumpang'],
            ['name' => 'Convertible', 'type' => 'Mobil Penumpang'],

            // Mobil Niaga
            ['name' => 'Pickup', 'type' => 'Mobil Niaga'],
            ['name' => 'Minibus', 'type' => 'Mobil Niaga'],
            ['name' => 'Van', 'type' => 'Mobil Niaga'],
            ['name' => 'Truk ringan', 'type' => 'Mobil Niaga'],

            // Kendaraan Khusus
            ['name' => 'Ambulans', 'type' => 'Kendaraan Khusus'],
            ['name' => 'Mobil pemadam kebakaran kecil', 'type' => 'Kendaraan Khusus'],
            ['name' => 'Mobil patroli polisi', 'type' => 'Kendaraan Khusus'],
            ['name' => 'Mobil derek', 'type' => 'Kendaraan Khusus'],
        ];

        DB::table('jenis')->insert($data);
    }
}
