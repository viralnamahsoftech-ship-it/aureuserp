<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\PartyContactPerson;

/**
 * @extends Factory<PartyContactPerson>
 */
class PartyContactPersonFactory extends Factory
{
    protected $model = PartyContactPerson::class;

    public function definition(): array
    {
        return [
            'site_name'    => fake()->words(3, true),
            'contact_name' => fake()->words(3, true),
            'mobile'       => '9876543210',
            'phone'        => fake()->words(3, true),
            'ext_no'       => fake()->words(3, true),
            'email'        => fake()->safeEmail(),
            'is_whatsapp'  => true,
            'auto_mail'    => true,
        ];
    }
}
