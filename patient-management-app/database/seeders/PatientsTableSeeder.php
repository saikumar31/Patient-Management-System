<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use Faker\Factory as Faker;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Patient::create([
                'name' => $faker->name,
                'age' => $faker->numberBetween(1, 100),
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'contact_info' => $faker->numerify('##########'),  // Generates a random 10-digit number
            ]);
        }
    }
}
