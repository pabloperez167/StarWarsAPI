<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Starship;

class StarshipFactory extends Factory
{
    protected $model = Starship::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'model' => $this->faker->word,
            'coste' => $this->faker->randomNumber(4),
        ];
    }
}
