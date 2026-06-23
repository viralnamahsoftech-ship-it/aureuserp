<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\SerialNoMaster;

/**
 * @extends Factory<SerialNoMaster>
 */
class SerialNoMasterFactory extends Factory
{
    protected $model = SerialNoMaster::class;

    public function definition(): array
    {
        return [
            'doc_type'   => fake()->words(3, true),
            'prefix'     => fake()->words(3, true),
            'suffix'     => fake()->words(3, true),
            'separator'  => fake()->words(3, true),
            'current_no' => fake()->numberBetween(1, 10),
            'pad_length' => fake()->numberBetween(1, 10),
            'is_active'  => true,
        ];
    }
}
