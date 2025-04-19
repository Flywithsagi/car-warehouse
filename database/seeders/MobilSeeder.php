<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    public function run()
    {
        // Data mobil penumpang
        $mobilPenumpang = [
            ['name' => 'Toyota Camry', 'brand' => 'Toyota', 'year' => 2020, 'quantity' => 10, 'jenis_id' => 1],
            ['name' => 'Honda Accord', 'brand' => 'Honda', 'year' => 2021, 'quantity' => 5, 'jenis_id' => 1],
            ['name' => 'Toyota Yaris', 'brand' => 'Toyota', 'year' => 2022, 'quantity' => 8, 'jenis_id' => 2],
            ['name' => 'Honda Jazz', 'brand' => 'Honda', 'year' => 2021, 'quantity' => 7, 'jenis_id' => 2],
            ['name' => 'Toyota Avanza', 'brand' => 'Toyota', 'year' => 2021, 'quantity' => 12, 'jenis_id' => 3],
            ['name' => 'Daihatsu Xenia', 'brand' => 'Daihatsu', 'year' => 2020, 'quantity' => 6, 'jenis_id' => 3],
            ['name' => 'Toyota Fortuner', 'brand' => 'Toyota', 'year' => 2020, 'quantity' => 4, 'jenis_id' => 4],
            ['name' => 'Honda CR-V', 'brand' => 'Honda', 'year' => 2021, 'quantity' => 5, 'jenis_id' => 4],
            ['name' => 'Nissan Juke', 'brand' => 'Nissan', 'year' => 2020, 'quantity' => 6, 'jenis_id' => 5],
            ['name' => 'Subaru XV', 'brand' => 'Subaru', 'year' => 2021, 'quantity' => 7, 'jenis_id' => 5],
            ['name' => 'BMW 4 Series', 'brand' => 'BMW', 'year' => 2022, 'quantity' => 3, 'jenis_id' => 6],
            ['name' => 'Mercedes-Benz C-Class Coupe', 'brand' => 'Mercedes-Benz', 'year' => 2021, 'quantity' => 4, 'jenis_id' => 6],
            ['name' => 'Mazda MX-5 Miata', 'brand' => 'Mazda', 'year' => 2021, 'quantity' => 5, 'jenis_id' => 7],
            ['name' => 'BMW Z4', 'brand' => 'BMW', 'year' => 2020, 'quantity' => 3, 'jenis_id' => 7],
        ];

        // Data mobil niaga
        $mobilNiaga = [
            ['name' => 'Toyota Hilux', 'brand' => 'Toyota', 'year' => 2021, 'quantity' => 8, 'jenis_id' => 8],
            ['name' => 'Isuzu D-Max', 'brand' => 'Isuzu', 'year' => 2020, 'quantity' => 10, 'jenis_id' => 8],
            ['name' => 'Toyota HiAce', 'brand' => 'Toyota', 'year' => 2021, 'quantity' => 12, 'jenis_id' => 9],
            ['name' => 'Daihatsu Luxio', 'brand' => 'Daihatsu', 'year' => 2020, 'quantity' => 6, 'jenis_id' => 9],
            ['name' => 'Suzuki Carry', 'brand' => 'Suzuki', 'year' => 2020, 'quantity' => 15, 'jenis_id' => 10],
            ['name' => 'Mitsubishi L300', 'brand' => 'Mitsubishi', 'year' => 2021, 'quantity' => 9, 'jenis_id' => 10],
            ['name' => 'Mitsubishi Canter', 'brand' => 'Mitsubishi', 'year' => 2020, 'quantity' => 5, 'jenis_id' => 11],
            ['name' => 'Isuzu N-Series', 'brand' => 'Isuzu', 'year' => 2021, 'quantity' => 7, 'jenis_id' => 11],
        ];

        // Data kendaraan khusus
        $kendaraanKhusus = [
            ['name' => 'Mercedes-Benz Sprinter Ambulance', 'brand' => 'Mercedes-Benz', 'year' => 2020, 'quantity' => 2, 'jenis_id' => 12],
            ['name' => 'Toyota HiAce Ambulance', 'brand' => 'Toyota', 'year' => 2021, 'quantity' => 1, 'jenis_id' => 12],
            ['name' => 'Land Rover Defender Fire Engine', 'brand' => 'Land Rover', 'year' => 2020, 'quantity' => 1, 'jenis_id' => 13],
            ['name' => 'Ford F-150 Fire Truck', 'brand' => 'Ford', 'year' => 2021, 'quantity' => 1, 'jenis_id' => 13],
            ['name' => 'Toyota Land Cruiser', 'brand' => 'Toyota', 'year' => 2020, 'quantity' => 5, 'jenis_id' => 14],
            ['name' => 'Ford Explorer Police Interceptor', 'brand' => 'Ford', 'year' => 2021, 'quantity' => 4, 'jenis_id' => 14],
        ];

        // Menyisipkan data ke dalam tabel 'mobil' dengan kode_mobil otomatis
        $allMobil = array_merge($mobilPenumpang, $mobilNiaga, $kendaraanKhusus);
        $no = 1;
        foreach ($allMobil as $mobil) {
            // Tambahkan kode_mobil dengan format MB0001, MB0002, dst.
            $mobil['kode_mobil'] = 'MB' . str_pad($no++, 4, '0', STR_PAD_LEFT);
            Mobil::create($mobil);
        }
    }
}
