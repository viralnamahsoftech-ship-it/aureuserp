<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\QcParameter;

/**
 * @extends Factory<QcParameter>
 */
class QcParameterFactory extends Factory
{
    protected $model = QcParameter::class;

    public function definition(): array
    {
        return [
            'parameter_name' => fake()->words(3, true),
            'is_active'      => true,
        ];
    }
}
