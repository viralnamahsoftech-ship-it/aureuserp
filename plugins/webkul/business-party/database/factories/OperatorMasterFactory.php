<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\OperatorMaster;

/**
 * @extends Factory<OperatorMaster>
 */
class OperatorMasterFactory extends Factory
{
    protected $model = OperatorMaster::class;

    public function definition(): array
    {
        return [
            'operator_name' => fake()->words(3, true),
            'is_active'     => true,
        ];
    }
}
