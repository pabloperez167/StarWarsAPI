<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pilot;
use App\Models\Starship;

class PilotFactory extends Factory
{
    protected $model = Pilot::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }

}
