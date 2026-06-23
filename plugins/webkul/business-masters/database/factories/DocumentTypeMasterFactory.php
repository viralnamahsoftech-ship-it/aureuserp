<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\DocumentTypeMaster;

/**
 * @extends Factory<DocumentTypeMaster>
 */
class DocumentTypeMasterFactory extends Factory
{
    protected $model = DocumentTypeMaster::class;

    public function definition(): array
    {
        return [
            'document_type' => 'Vendor Quotation',
            'sub_doc_type'  => fake()->words(3, true),
            'is_active'     => true,
        ];
    }
}
