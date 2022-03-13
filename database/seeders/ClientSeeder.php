<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Carbon\Carbon;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            Client::create([
                'client_name' => $i.'email@example.com',
                'address1' => $i.'address1',
                'address2' => $i.'address2',
                'city' => $i.'city',
                'state' => $i.'store',
                'country' => $i.'country',
                'latitude' => $i,
                'longitude' => $i,
                'phone_no1' => '0102788789'.$i,
                'phone_no2' => '0102788789'.$i.$i,
                'zip' => rand(11111, 99999),
                'start_validity' => Carbon::now(),
                'end_validity' => Carbon::now()->addDays(15),
                'status' => 'Active',
            ]); 
        }
    }
}
