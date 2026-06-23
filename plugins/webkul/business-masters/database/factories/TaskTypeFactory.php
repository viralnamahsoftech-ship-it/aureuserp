<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\TaskType;

/**
 * @extends Factory<TaskType>
 */
class TaskTypeFactory extends Factory
{
    protected $model = TaskType::class;

    public function definition(): array
    {
        return [
            'task_name' => fake()->words(3, true),
            'is_active' => true,
        ];
    }
}
