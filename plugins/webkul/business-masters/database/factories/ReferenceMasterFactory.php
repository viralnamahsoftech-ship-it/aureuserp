<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\ReferenceMaster;

/**
 * @extends Factory<ReferenceMaster>
 */
class ReferenceMasterFactory extends Factory
{
    protected $model = ReferenceMaster::class;

    public function definition(): array
    {
        return [
            'ref_name'  => fake()->words(3, true),
            'ref_type'  => fake()->words(3, true),
            'is_active' => true,
        ];
    }
}
