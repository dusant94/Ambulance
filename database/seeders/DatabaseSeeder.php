<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            TypDoctorSeeder::class,
        ]);
        \App\Models\Location::factory(15)->create();
        \App\Models\User::factory(15)->create();
        \App\Models\Patient::factory(15)->create();
        \App\Models\Examination::factory(1000)->create();

    }
}
