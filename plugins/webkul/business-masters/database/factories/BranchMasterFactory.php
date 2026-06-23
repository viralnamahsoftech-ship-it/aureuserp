<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\BranchMaster;

/**
 * @extends Factory<BranchMaster>
 */
class BranchMasterFactory extends Factory
{
    protected $model = BranchMaster::class;

    public function definition(): array
    {
        return [
            'branch_code' => strtoupper(fake()->bothify('BRAN-####')),
            'branch_name' => fake()->words(3, true),
            'address'     => fake()->sentence(),
            'city'        => fake()->words(3, true),
            'state'       => fake()->words(3, true),
            'country'     => fake()->words(3, true),
            'pincode'     => fake()->words(3, true),
            'header_file' => null,
            'footer_file' => null,
            'is_active'   => true,
        ];
    }
}
