<?php

namespace Database\Factories;

use App\Models\TypDoctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $doctor_types = TypDoctor::pluck('id')->toArray();
        return [
            'name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'role' => 'doctor',
            'type' =>  $this->faker->randomElement($doctor_types),
            'username' => $this->faker->unique()->name(),
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}