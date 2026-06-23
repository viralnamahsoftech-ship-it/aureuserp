<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\IndustryType;

/**
 * @extends Factory<IndustryType>
 */
class IndustryTypeFactory extends Factory
{
    protected $model = IndustryType::class;

    public function definition(): array
    {
        return [
            'industry_name' => fake()->words(3, true),
            'is_active'     => true,
        ];
    }
}
