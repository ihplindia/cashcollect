<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('users')->insert([
         'name' => 'sabbir Hossain',
         'email' => 'sabbir@gmail.com',
         'phone' => '01797152105',
         'password' => Hash::make('12345678'),
         'role' =>1,
         'created_at' =>Carbon::now()->toDateTimeString(),
     ]);
    }
}
