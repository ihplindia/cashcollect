<?php

namespace Database\Factories;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ExpenseCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExpenseCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        return [
          'expcate_name' => $this->faker->sentence($nbWords = 3, $variableNbWords = true),
          'expcate_remarks'=> $this->faker->paragraph($nbSentences = 1, $variableNbSentences = true),
           'expcate_creator' =>1,
           'expcate_slug' => 'Ec'.uniqid(),
           'created_at' =>Carbon::now()->toDateTimeString(),
        ];
    }
}
