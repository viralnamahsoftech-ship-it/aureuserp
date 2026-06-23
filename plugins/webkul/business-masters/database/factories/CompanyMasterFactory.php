<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\CompanyMaster;

/**
 * @extends Factory<CompanyMaster>
 */
class CompanyMasterFactory extends Factory
{
    protected $model = CompanyMaster::class;

    public function definition(): array
    {
        return [
            'company_code' => strtoupper(fake()->bothify('COMP-####')),
            'company_name' => fake()->words(3, true),
            'gstin'        => fake()->words(3, true),
            'pan_no'       => fake()->words(3, true),
            'address'      => fake()->sentence(),
            'city'         => fake()->words(3, true),
            'state'        => fake()->words(3, true),
            'country'      => fake()->words(3, true),
            'pincode'      => fake()->words(3, true),
            'phone'        => fake()->words(3, true),
            'mobile'       => fake()->words(3, true),
            'email'        => fake()->safeEmail(),
            'logo_path'    => null,
            'is_active'    => true,
        ];
    }
}
