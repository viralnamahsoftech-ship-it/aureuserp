<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\Department;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'dept_code' => strtoupper(fake()->bothify('DEPA-####')),
            'dept_name' => fake()->words(3, true),
            'is_active' => true,
        ];
    }
}
