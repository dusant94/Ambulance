<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locations = Location::pluck('id')->toArray();

        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'location_id' =>  $this->faker->randomElement($locations),
            'jmbg' => rand(10**12,10**13-1),
            'note' => $this->faker->text(),
        ];
    }
}
