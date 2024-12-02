<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => now()->addDays(rand(1, 30)), // Menghasilkan tanggal acak
            'start_time' => $this->faker->time(), // Menghasilkan waktu mulai acak
            'end_time' => $this->faker->time(), // Menghasilkan waktu selesai acak
            'topic' => $this->faker->sentence(3), // Menghasilkan topik acak
            'room' => $this->faker->word(), // Menghasilkan nama ruangan acak
            'status' => 'OPEN',
        ];
    }
}
