<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\PartyBankDetail;

/**
 * @extends Factory<PartyBankDetail>
 */
class PartyBankDetailFactory extends Factory
{
    protected $model = PartyBankDetail::class;

    public function definition(): array
    {
        return [
            'bank_name'      => fake()->words(3, true),
            'account_name'   => fake()->words(3, true),
            'account_no'     => fake()->words(3, true),
            'account_type'   => fake()->words(3, true),
            'ifsc_code'      => strtoupper(fake()->bothify('PART-####')),
            'ocr_no'         => fake()->words(3, true),
            'icri_number'    => fake()->words(3, true),
            'branch_name'    => fake()->words(3, true),
            'branch_address' => fake()->sentence(),
            'branch_code'    => strtoupper(fake()->bothify('PART-####')),
            'is_whatsapp'    => true,
            'auto_mail'      => true,
        ];
    }
}
