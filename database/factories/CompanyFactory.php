<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'manager_first_name' => $this->faker->name(),
            'manager_last_name' => $this->faker->name(),
            'name' => $this->faker->name(),
            "profile_media_id" => null,
            'designation' => 'manager',
            'manager_email' => $this->faker->unique()->safeEmail(),
            'manager_phone' => "03131149754",
        ];
    }
}
