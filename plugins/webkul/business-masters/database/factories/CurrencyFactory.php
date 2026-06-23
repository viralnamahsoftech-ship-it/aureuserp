<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\Currency;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        return [
            'currency_code' => strtoupper(fake()->bothify('CURR-####')),
            'currency_name' => fake()->words(3, true),
            'conv_rate'     => fake()->randomFloat(4, 1, 50),
            'is_active'     => true,
        ];
    }
}
