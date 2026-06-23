<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\Country;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'country_code' => strtoupper(fake()->bothify('COUN-####')),
            'country_name' => fake()->words(3, true),
            'is_active'    => true,
        ];
    }
}
