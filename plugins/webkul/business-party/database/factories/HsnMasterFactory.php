<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\HsnMaster;

/**
 * @extends Factory<HsnMaster>
 */
class HsnMasterFactory extends Factory
{
    protected $model = HsnMaster::class;

    public function definition(): array
    {
        return [
            'hsn_no'    => fake()->words(3, true),
            'hsn_desc'  => fake()->words(3, true),
            'sgst'      => fake()->randomFloat(4, 1, 50),
            'cgst'      => fake()->randomFloat(4, 1, 50),
            'igst'      => fake()->randomFloat(4, 1, 50),
            'psgt_gl'   => fake()->words(3, true),
            'pcgt_gl'   => fake()->words(3, true),
            'pigt_gl'   => fake()->words(3, true),
            'ssgt_gl'   => fake()->words(3, true),
            'scgt_gl'   => fake()->words(3, true),
            'sigt_gl'   => fake()->words(3, true),
            'is_active' => true,
        ];
    }
}
