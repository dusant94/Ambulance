<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultUser =  [
            'name' => 'counter',
            'last_name' => 'counter',
            'role' => 'counter',
            'username' => 'counter',
            'email_verified_at' => now(),
            'password' => Hash::make('counter'),
            'remember_token' => Str::random(10),
        ];
        $user = User::where('username', '=', $defaultUser['username'])->first();
        if ($user === null) {
            \App\Models\User::factory()->create($defaultUser);
        }
    }
}
