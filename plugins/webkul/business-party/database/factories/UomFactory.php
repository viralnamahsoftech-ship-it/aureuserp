<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\Uom;

/**
 * @extends Factory<Uom>
 */
class UomFactory extends Factory
{
    protected $model = Uom::class;

    public function definition(): array
    {
        return [
            'uom_desc'  => fake()->words(3, true),
            'is_active' => true,
        ];
    }
}
