<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\QcTemplateLine;

/**
 * @extends Factory<QcTemplateLine>
 */
class QcTemplateLineFactory extends Factory
{
    protected $model = QcTemplateLine::class;

    public function definition(): array
    {
        return [
            'min_value'   => fake()->randomFloat(4, 1, 50),
            'max_value'   => fake()->randomFloat(4, 1, 50),
            'result_type' => 'Yes',
            'sort_order'  => fake()->numberBetween(1, 10),
        ];
    }
}
