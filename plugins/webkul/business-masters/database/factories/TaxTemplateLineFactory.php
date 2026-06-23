<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\TaxTemplateLine;

/**
 * @extends Factory<TaxTemplateLine>
 */
class TaxTemplateLineFactory extends Factory
{
    protected $model = TaxTemplateLine::class;

    public function definition(): array
    {
        return [
            'percentage' => fake()->randomFloat(4, 1, 50),
            'amount'     => fake()->randomFloat(4, 1, 50),
            'gl_code'    => strtoupper(fake()->bothify('TAX_-####')),
        ];
    }
}
