<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\BomMaster;

/**
 * @extends Factory<BomMaster>
 */
class BomMasterFactory extends Factory
{
    protected $model = BomMaster::class;

    public function definition(): array
    {
        return [
            'bom_code'  => strtoupper(fake()->bothify('BOM_-####')),
            'bom_name'  => fake()->words(3, true),
            'revision'  => fake()->words(3, true),
            'is_active' => true,
        ];
    }
}
