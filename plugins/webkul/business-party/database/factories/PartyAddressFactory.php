<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\PartyAddress;

/**
 * @extends Factory<PartyAddress>
 */
class PartyAddressFactory extends Factory
{
    protected $model = PartyAddress::class;

    public function definition(): array
    {
        return [
            'site_name'    => fake()->words(3, true),
            'address_type' => 'Billing',
            'address'      => fake()->sentence(),
            'state_code'   => strtoupper(fake()->bothify('PART-####')),
            'pincode'      => fake()->words(3, true),
            'phone'        => fake()->words(3, true),
            'mobile'       => '9876543210',
            'email'        => fake()->safeEmail(),
            'gstin'        => fake()->words(3, true),
            'is_whatsapp'  => true,
            'auto_mail'    => true,
        ];
    }
}
