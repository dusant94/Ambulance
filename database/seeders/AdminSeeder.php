<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultUser =  [
            'name' => 'admin',
            'last_name' => 'admin',
            'role' => 'admin',
            'username' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ];


        $user = User::where('username', '=', $defaultUser['username'])->first();
        if ($user === null) {
            \App\Models\User::factory()->create($defaultUser);
        }
    }
}
