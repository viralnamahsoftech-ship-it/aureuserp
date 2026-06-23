<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\BomLine;

/**
 * @extends Factory<BomLine>
 */
class BomLineFactory extends Factory
{
    protected $model = BomLine::class;

    public function definition(): array
    {
        return [
            'qty'        => fake()->randomFloat(4, 1, 50),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
