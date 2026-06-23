<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\StageMaster;

/**
 * @extends Factory<StageMaster>
 */
class StageMasterFactory extends Factory
{
    protected $model = StageMaster::class;

    public function definition(): array
    {
        return [
            'form_name'  => 'Lead',
            'stage_name' => fake()->words(3, true),
            'details'    => fake()->sentence(),
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active'  => true,
        ];
    }
}
