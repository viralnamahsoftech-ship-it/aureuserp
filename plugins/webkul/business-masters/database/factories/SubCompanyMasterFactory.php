<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\SubCompanyMaster;

/**
 * @extends Factory<SubCompanyMaster>
 */
class SubCompanyMasterFactory extends Factory
{
    protected $model = SubCompanyMaster::class;

    public function definition(): array
    {
        return [
            'sub_company_code' => strtoupper(fake()->bothify('SUB_-####')),
            'sub_company_name' => fake()->words(3, true),
            'address'          => fake()->sentence(),
            'is_active'        => true,
        ];
    }
}
