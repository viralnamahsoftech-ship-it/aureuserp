<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\DocWiseSerialNo;

/**
 * @extends Factory<DocWiseSerialNo>
 */
class DocWiseSerialNoFactory extends Factory
{
    protected $model = DocWiseSerialNo::class;

    public function definition(): array
    {
        return [
            'document_type' => fake()->words(3, true),
        ];
    }
}
