<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\DocumentUserDetail;

/**
 * @extends Factory<DocumentUserDetail>
 */
class DocumentUserDetailFactory extends Factory
{
    protected $model = DocumentUserDetail::class;

    public function definition(): array
    {
        return [
            'sub_doc_type' => fake()->words(3, true),
        ];
    }
}
