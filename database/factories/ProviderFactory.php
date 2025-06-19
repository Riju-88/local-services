<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // --- Core & Required Fields ---
            'user_id' => User::factory(),
            'providable_type' => Service::class,
            'providable_id' => Service::factory(),
            'business_name' => $this->faker->company,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph(3),
            'email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->streetAddress,
            'pincode' => $this->faker->postcode,
            'contact_person_name' => $this->faker->name,
            'contact_person_role' => 'Manager',
            'contact_person_phone' => $this->faker->phoneNumber,
            
            // --- Newly Added Nullable & Optional Fields ---
            'alternate_phone' => $this->faker->phoneNumber,
            'whatsapp_number' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'area' => $this->faker->citySuffix,
            'contact_person_email' => $this->faker->safeEmail,
            'contact_person_whatsapp' => $this->faker->phoneNumber,
            'established_year' => $this->faker->numberBetween(1980, date('Y') - 1),
            'working_hours' => [
                'days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'from' => '09:00',
                'to' => '17:00',
            ],
            'tags' => [$this->faker->word, $this->faker->word, $this->faker->word],
            'is_active' => true,
            'is_verified' => $this->faker->boolean(25), // 25% chance of being verified
            'featured' => $this->faker->boolean(10),  // 10% chance of being featured
            'views' => $this->faker->numberBetween(0, 5000),
            
            // Note: 'photos' and 'logo' are intentionally left out, as it's better
            // to handle file uploads specifically within the tests that need them.
            // They will default to null, which is correct.
        ];
    }
}