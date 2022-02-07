<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CentroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'descripcion' => $this->faker->Sentence(),
            'cod_asd' => $this->faker->randomDigit(),
            'fec_comienzo_actividad' => $this->faker->date(),
            'opcion_radio' => $this->faker->word(),
            'guarderia' => $this->faker->boolean(),
            'categoria' => $this->faker->randomDigit(),
        ];
    }
}
