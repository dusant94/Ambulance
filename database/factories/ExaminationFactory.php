<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ExaminationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $doctors = User::where('role', 'doctor')->pluck('id')->toArray();
        $patients = Patient::pluck('id')->toArray();
        return [
            'doctor_id' =>  $this->faker->randomElement($doctors),
            'patient_id' => $this->faker->randomElement($patients),
            'parformed' => rand(0,1),
            'time_of_examination' => now(),
            'diagnosis' => Str::random(100),
        ];
    }
}
