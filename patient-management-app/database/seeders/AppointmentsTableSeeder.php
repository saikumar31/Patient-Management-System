<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Faker\Factory as Faker;
use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $allSlots = ['10:00:00', '12:00:00', '14:00:00', '16:00:00', '18:00:00', '22:00:00'];

        foreach (range(1, 50) as $index) {
            Appointment::create([
                'patient_id' => Patient::inRandomOrder()->first()->id,
                'doctor_id' => Doctor::inRandomOrder()->first()->id,
                'date' => Carbon::now()->addDays($faker->numberBetween(1, 10)),
                'time' => $faker->randomElement($allSlots), // Randomly select from the predefined slots
                'status' => $faker->randomElement(['Booked', 'Completed', 'Canceled']),
            ]);
        }
    }
}
