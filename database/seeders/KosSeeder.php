<?php

namespace Database\Seeders;

use App\Models\kos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker= \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            kos::create([
                'nama' => $faker->company,
                'deskripsi' => $faker->text(500),
                'harga' => $faker->numberBetween(300, 1000000),
                'lokasi' => $faker->address,
            ]);
        }
    }
}
