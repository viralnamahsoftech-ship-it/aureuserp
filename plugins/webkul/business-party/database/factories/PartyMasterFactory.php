<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\PartyMaster;

/**
 * @extends Factory<PartyMaster>
 */
class PartyMasterFactory extends Factory
{
    protected $model = PartyMaster::class;

    public function definition(): array
    {
        return [
            'party_code'             => strtoupper(fake()->bothify('PART-####')),
            'party_name'             => fake()->words(3, true),
            'ho_address'             => fake()->sentence(),
            'pincode'                => fake()->words(3, true),
            'phone'                  => fake()->words(3, true),
            'mobile'                 => '9876543210',
            'email'                  => fake()->safeEmail(),
            'gst_supply_type'        => 'InterState',
            'tax_on'                 => 'ItemWise',
            'gstin'                  => fake()->words(3, true),
            'pan_no'                 => fake()->words(3, true),
            'ecc_no'                 => fake()->words(3, true),
            'uan_no'                 => fake()->words(3, true),
            'tin_no'                 => fake()->words(3, true),
            'msme_no'                => fake()->words(3, true),
            'msme_type'              => 'High',
            'udaid_no'               => fake()->words(3, true),
            'other_ref_no'           => fake()->words(3, true),
            'op_bal'                 => fake()->randomFloat(4, 1, 50),
            'op_bal_type'            => 'Dr',
            'is_tds_applicable'      => true,
            'gl_tds_code'            => strtoupper(fake()->bothify('PART-####')),
            'credit_limit'           => fake()->randomFloat(4, 1, 50),
            'allow_multiple_invoice' => true,
            'is_parent_party'        => true,
            'is_active'              => true,
        ];
    }
}
