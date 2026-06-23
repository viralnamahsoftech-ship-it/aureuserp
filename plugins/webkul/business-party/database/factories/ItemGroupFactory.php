<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\ItemGroup;

/**
 * @extends Factory<ItemGroup>
 */
class ItemGroupFactory extends Factory
{
    protected $model = ItemGroup::class;

    public function definition(): array
    {
        return [
            'group_code' => strtoupper(fake()->bothify('ITEM-####')),
            'group_name' => fake()->words(3, true),
            'is_active'  => true,
        ];
    }
}
