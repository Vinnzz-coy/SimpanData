<?php

namespace Database\Factories;

use App\Models\Peserta;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'peserta_id' => Peserta::factory(),
            'pengirim' => fake()->randomElement(['Peserta', 'Admin']),
            'pesan' => fake()->paragraph(3),
            'dibaca' => fake()->boolean(70), // 70% chance dibaca
        ];
    }
}
