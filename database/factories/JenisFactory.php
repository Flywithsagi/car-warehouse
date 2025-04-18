<?php
namespace Database\Factories;

use App\Models\Jenis;
use Illuminate\Database\Eloquent\Factories\Factory;

class JenisFactory extends Factory
{
    protected $model = Jenis::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Menghasilkan kata acak
            'type' => $this->faker->word, // Menghasilkan kata acak
        ];
    }
}

