<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use Faker\Factory as Faker;

class DoctorsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 30) as $index) {
            Doctor::create([
                'name' => $faker->name,
                'specialization' => $faker->randomElement(['Cardiology', 'Dermatology', 'Surgery', 'Pediatrics']),
                'contact_info' => $faker->numerify('##########'),  // 10-digit number
            ]);
        }
    }
}
