<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\ItemCategory;

/**
 * @extends Factory<ItemCategory>
 */
class ItemCategoryFactory extends Factory
{
    protected $model = ItemCategory::class;

    public function definition(): array
    {
        return [
            'category_name' => fake()->words(3, true),
            'is_active'     => true,
        ];
    }
}
