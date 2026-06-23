<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\QcTemplate;

/**
 * @extends Factory<QcTemplate>
 */
class QcTemplateFactory extends Factory
{
    protected $model = QcTemplate::class;

    public function definition(): array
    {
        return [
            'qc_temp_code' => strtoupper(fake()->bothify('QC_T-####')),
            'qc_temp_name' => fake()->words(3, true),
            'is_active'    => true,
        ];
    }
}
