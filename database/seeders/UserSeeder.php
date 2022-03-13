<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            User::create([
                'client_id' => $i,
                'first_name' => $i.' Frst Name',
                'last_name' => $i.' Last Name',
                'email' => $i.'email@example.com',
                'password' => Hash::make('12345678'),
                'phone' => '0102788789'.$i,
                'profile_uri' => 'https://www.facebook.com',
                'last_password_reset' => null,
                'status' => 'Active',
            ]);
        }
    }
}
