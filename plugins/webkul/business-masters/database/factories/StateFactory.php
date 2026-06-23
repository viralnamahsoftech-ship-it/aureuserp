<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\State;

/**
 * @extends Factory<State>
 */
class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
        return [
            'state_code' => strtoupper(fake()->bothify('STAT-####')),
            'state_name' => fake()->words(3, true),
            'is_active'  => true,
        ];
    }
}
