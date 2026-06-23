<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\ProcessMaster;

/**
 * @extends Factory<ProcessMaster>
 */
class ProcessMasterFactory extends Factory
{
    protected $model = ProcessMaster::class;

    public function definition(): array
    {
        return [
            'pr_code'      => strtoupper(fake()->bothify('PROC-####')),
            'process_name' => fake()->words(3, true),
            'is_active'    => true,
        ];
    }
}
