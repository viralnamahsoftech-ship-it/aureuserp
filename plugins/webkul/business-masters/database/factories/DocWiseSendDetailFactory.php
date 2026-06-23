<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\DocWiseSendDetail;

/**
 * @extends Factory<DocWiseSendDetail>
 */
class DocWiseSendDetailFactory extends Factory
{
    protected $model = DocWiseSendDetail::class;

    public function definition(): array
    {
        return [
            'document_type'     => fake()->words(3, true),
            'send_via_email'    => true,
            'send_via_whatsapp' => true,
            'email_template'    => fake()->sentence(),
            'whatsapp_template' => fake()->sentence(),
        ];
    }
}
