<?php

namespace Database\Factories;

use App\Models\Service; // <-- Import the parent Service model
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            // This is the crucial fix.
            // For every ServiceCategory created, also create a parent Service
            // and assign its ID.
            'service_id' => Service::factory(),
        ];
    }
}