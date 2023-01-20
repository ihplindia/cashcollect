<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        return [
          'expcate_id' =>1,
          'expense_title' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
           'expense_date' => $this->faker->date('d-m-Y'),
           'expense_amount' =>rand(10000,100000),
           'expense_creator' =>1,
           'expense_slug' => 'IC'.uniqid(),
           'created_at' =>Carbon::now()->toDateTimeString(),
        ];
    }
}
