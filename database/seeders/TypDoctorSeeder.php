<?php

namespace Database\Seeders;

use App\Models\TypDoctor;
use Illuminate\Database\Seeder;

class TypDoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (["Stomatolog", "Hirurg", "Pedijatar"] as $type) {
            $typ = TypDoctor::where('name', $type)->first();
            if ($typ === null) {
                TypDoctor::create(['name' => $type]);
            }
        }
    }
}
