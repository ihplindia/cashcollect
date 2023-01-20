<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      DB::table('income_categories')->insert([
        'incate_name' =>'job purpose',
        'incate_remarks' =>'My Income From Private Job',
        'incate_creator' =>1,
        'incate_slug' => 'Inc'.Str::random(10),
        'created_at' =>Carbon::now()->toDateTimeString(),
      ]);
    }
}
