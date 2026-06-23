<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\PartyGroup;

/**
 * @extends Factory<PartyGroup>
 */
class PartyGroupFactory extends Factory
{
    protected $model = PartyGroup::class;

    public function definition(): array
    {
        return [
            'group_name' => fake()->words(3, true),
            'is_active'  => true,
        ];
    }
}
