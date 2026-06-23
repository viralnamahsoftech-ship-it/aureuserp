<?php

namespace Webkul\BusinessParty\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessParty\Models\ItemMaster;

/**
 * @extends Factory<ItemMaster>
 */
class ItemMasterFactory extends Factory
{
    protected $model = ItemMaster::class;

    public function definition(): array
    {
        return [
            'item_code'         => strtoupper(fake()->bothify('ITEM-####')),
            'item_name'         => fake()->words(3, true),
            'item_type'         => 'Sales',
            'process_type'      => 'Procured',
            'conv_qty'          => fake()->randomFloat(4, 1, 50),
            'purch_conv_qty'    => fake()->randomFloat(4, 1, 50),
            'sales_conv_qty'    => fake()->randomFloat(4, 1, 50),
            'detail_desc'       => fake()->sentence(),
            'drawing_no'        => fake()->words(3, true),
            'drawing_rev_no'    => fake()->words(3, true),
            'part_no'           => fake()->words(3, true),
            'qc_required'       => true,
            'qc_param_required' => true,
            'location'          => fake()->words(3, true),
            'internal_remarks'  => fake()->sentence(),
            'make'              => fake()->words(3, true),
            'serial_no_code'    => strtoupper(fake()->bothify('ITEM-####')),
            'min_stock'         => fake()->randomFloat(4, 1, 50),
            'moq'               => fake()->randomFloat(4, 1, 50),
            'lead_time'         => fake()->numberBetween(1, 10),
            'class_name'        => fake()->words(3, true),
            'manual_trans'      => true,
            'tolerance_plus'    => fake()->randomFloat(4, 1, 50),
            'tolerance_minus'   => fake()->randomFloat(4, 1, 50),
            'max_qty'           => fake()->randomFloat(4, 1, 50),
            'max_order_qty'     => fake()->randomFloat(4, 1, 50),
            'reorder_qty'       => fake()->randomFloat(4, 1, 50),
            'grn_required'      => true,
            'material_provide'  => true,
            'size_packet_qty'   => fake()->randomFloat(4, 1, 50),
            'self_life'         => fake()->numberBetween(1, 10),
            'warranty_period'   => fake()->numberBetween(1, 10),
            'acct_gl_code'      => strtoupper(fake()->bothify('ITEM-####')),
            'is_active'         => true,
            'batch_wise'        => true,
            'serial_no_wise'    => true,
            'account_effect'    => true,
            'is_stock_effect'   => true,
            'planning'          => 'Against Order',
            'gst_on'            => 'ItemWise',
            'gst_supply_type'   => 'InterState',
        ];
    }
}
