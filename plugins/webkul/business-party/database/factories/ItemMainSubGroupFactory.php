<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\ItemMainSubGroup;

/**
 * @extends Factory<ItemMainSubGroup>
 */
class ItemMainSubGroupFactory extends Factory
{
    protected $model = ItemMainSubGroup::class;

    public function definition(): array
    {
        return [
            'group_name' => fake()->words(3, true),
            'group_type' => 'Main',
            'is_active'  => true,
        ];
    }
}
