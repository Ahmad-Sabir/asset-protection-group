<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the user seeds.
     *
     * @return void
     */

    public function run()
    {
        User::updateOrCreate(['email' => 'admin@gmail.com'], [
            'email'                 => 'admin@gmail.com',
            'password'              => '$2y$10$eYtbRbG1WjXzb1Z4glVBv.a2h7wxSzSUo/dBFRBWTtfHTL3HU4JEC', // admin0101,
            'last_name'             => 'admin',
            'first_name'            => 'super',
            'remember_token'        => Str::random(10),
            'is_update_password'    => 1,
            'user_status'           => config('apg.user_status.super-admin'),
        ]);
    }
}
