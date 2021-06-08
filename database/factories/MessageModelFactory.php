<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MessageModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MessageModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'message' => $this->faker->text,
            'module' => $this->faker->text(50),
            'action' => $this->faker->text(50),
        ];
    }
}
