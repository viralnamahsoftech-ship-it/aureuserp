<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\TaxMaster;

/**
 * @extends Factory<TaxMaster>
 */
class TaxMasterFactory extends Factory
{
    protected $model = TaxMaster::class;

    public function definition(): array
    {
        return [
            'tax_code'   => strtoupper(fake()->bothify('TAX_-####')),
            'tax_name'   => fake()->words(3, true),
            'percentage' => fake()->randomFloat(4, 1, 50),
            'amount'     => fake()->randomFloat(4, 1, 50),
            'gl_code'    => strtoupper(fake()->bothify('TAX_-####')),
            'is_active'  => true,
        ];
    }
}
