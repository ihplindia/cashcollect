<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        return [
          'incate_id' =>1,
          'income_title' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
           'income_date' => $this->faker->date('d-m-Y'),
           'income_amount' =>rand(10000,100000),
           'income_creator' =>1,
           'income_slug' => 'IC'.uniqid(),
           'created_at' =>Carbon::now()->toDateTimeString(),
        ];
    }
}
