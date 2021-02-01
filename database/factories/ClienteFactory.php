<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre'=> $this->faker->name(),
            'ap'=> $this->faker->lastName(),
            'am'=> $this->faker->lastName(),
            'fecha_nacimiento'=> $this->faker->date('Y-m-d', 1461067200),
            'genero'=> $this->faker->randomElement(['M','F'])
        ];
    }
}
