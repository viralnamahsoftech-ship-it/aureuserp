<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\TaxTemplate;

/**
 * @extends Factory<TaxTemplate>
 */
class TaxTemplateFactory extends Factory
{
    protected $model = TaxTemplate::class;

    public function definition(): array
    {
        return [
            'template_name' => fake()->words(3, true),
            'definition'    => fake()->sentence(),
            'is_active'     => true,
        ];
    }
}
