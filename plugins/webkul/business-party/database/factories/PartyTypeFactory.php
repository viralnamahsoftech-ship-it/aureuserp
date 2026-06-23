<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\PartyType;

/**
 * @extends Factory<PartyType>
 */
class PartyTypeFactory extends Factory
{
    protected $model = PartyType::class;

    public function definition(): array
    {
        return [
            'ptype'     => 'Supplier',
            'pstype'    => fake()->words(3, true),
            'is_active' => true,
        ];
    }
}
