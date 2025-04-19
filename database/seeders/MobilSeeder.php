<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    public function run()
    {
        // Mobil Penumpang
        $mobilPenumpang = [
            // Sedan
            ['name' => 'Toyota Camry', 'brand' => 'Toyota', 'year' => 2020, 'quantity' => 10, 'jenis_id' => 1],
            ['name' => 'Honda Accord', 'brand' => 'Honda', 'year' => 2021, 'quantity' => 5, 'jenis_id' => 1],

            // Hatchback
            ['name' => 'Toyota Yaris', 'brand' => 'Toyota', 'year' => 2022, 'quantity' => 8, 'jenis_id' => 2],
            ['name' => 'Honda Jazz', 'brand' => 'Honda', 'year' => 2021, 'quantity' => 7, 'jenis_id' => 2],

            // MPV
            ['name' => 'Toyota Avanza', 'brand' => 'Toyota', 'year' => 2021, 'quantity' => 12, 'jenis_id' => 3],
            ['name' => 'Daihatsu Xenia', 'brand' => 'Daihatsu', 'year' => 2020, 'quantity' => 6, 'jenis_id' => 3],

            // SUV
            ['name' => 'Toyota Fortuner', 'brand' => 'Toyota', 'year' => 2020, 'quantity' => 4, 'jenis_id' => 4],
            ['name' => 'Honda CR-V', 'brand' => 'Honda', 'year' => 2021, 'quantity' => 5, 'jenis_id' => 4],

            // Crossover
            ['name' => 'Nissan Juke', 'brand' => 'Nissan', 'year' => 2020, 'quantity' => 6, 'jenis_id' => 5],
            ['name' => 'Subaru XV', 'brand' => 'Subaru', 'year' => 2021, 'quantity' => 7, 'jenis_id' => 5],

            // Coupe
            ['name' => 'BMW 4 Series', 'brand' => 'BMW', 'year' => 2022, 'quantity' => 3, 'jenis_id' => 6],
            ['name' => 'Mercedes-Benz C-Class Coupe', 'brand' => 'Mercedes-Benz', 'year' => 2021, 'quantity' => 4, 'jenis_id' => 6],

            // Convertible
            ['name' => 'Mazda MX-5 Miata', 'brand' => 'Mazda', 'year' => 2021, 'quantity' => 5, 'jenis_id' => 7],
            ['name' => 'BMW Z4', 'brand' => 'BMW', 'year' => 2020, 'quantity' => 3, 'jenis_id' => 7],
        ];

        // Mobil Niaga
        $mobilNiaga = [
            // Pickup
            ['name' => 'Toyota Hilux', 'brand' => 'Toyota', 'year' => 2021, 'quantity' => 8, 'jenis_id' => 8],
            ['name' => 'Isuzu D-Max', 'brand' => 'Isuzu', 'year' => 2020, 'quantity' => 10, 'jenis_id' => 8],

            // Minibus
            ['name' => 'Toyota HiAce', 'brand' => 'Toyota', 'year' => 2021, 'quantity' => 12, 'jenis_id' => 9],
            ['name' => 'Daihatsu Luxio', 'brand' => 'Daihatsu', 'year' => 2020, 'quantity' => 6, 'jenis_id' => 9],

            // Van
            ['name' => 'Suzuki Carry', 'brand' => 'Suzuki', 'year' => 2020, 'quantity' => 15, 'jenis_id' => 10],
            ['name' => 'Mitsubishi L300', 'brand' => 'Mitsubishi', 'year' => 2021, 'quantity' => 9, 'jenis_id' => 10],

            // Truk Ringan
            ['name' => 'Mitsubishi Canter', 'brand' => 'Mitsubishi', 'year' => 2020, 'quantity' => 5, 'jenis_id' => 11],
            ['name' => 'Isuzu N-Series', 'brand' => 'Isuzu', 'year' => 2021, 'quantity' => 7, 'jenis_id' => 11],
        ];

        // Kendaraan Khusus
        $kendaraanKhusus = [
            // Ambulans
            ['name' => 'Mercedes-Benz Sprinter Ambulance', 'brand' => 'Mercedes-Benz', 'year' => 2020, 'quantity' => 2, 'jenis_id' => 12],
            ['name' => 'Toyota HiAce Ambulance', 'brand' => 'Toyota', 'year' => 2021, 'quantity' => 1, 'jenis_id' => 12],

            // Mobil Pemadam Kebakaran Kecil
            ['name' => 'Land Rover Defender Fire Engine', 'brand' => 'Land Rover', 'year' => 2020, 'quantity' => 1, 'jenis_id' => 13],
            ['name' => 'Ford F-150 Fire Truck', 'brand' => 'Ford', 'year' => 2021, 'quantity' => 1, 'jenis_id' => 13],

            // Mobil Patroli Polisi
            ['name' => 'Toyota Land Cruiser', 'brand' => 'Toyota', 'year' => 2020, 'quantity' => 5, 'jenis_id' => 14],
            ['name' => 'Ford Explorer Police Interceptor', 'brand' => 'Ford', 'year' => 2021, 'quantity' => 4, 'jenis_id' => 14],
        ];

        // Menyisipkan data ke dalam tabel 'mobil'
        foreach (array_merge($mobilPenumpang, $mobilNiaga, $kendaraanKhusus) as $mobil) {
            Mobil::create($mobil);
        }
    }
}
