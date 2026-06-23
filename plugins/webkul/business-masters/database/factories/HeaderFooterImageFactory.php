<?php

namespace Webkul\BusinessMasters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\BusinessMasters\Models\HeaderFooterImage;

/**
 * @extends Factory<HeaderFooterImage>
 */
class HeaderFooterImageFactory extends Factory
{
    protected $model = HeaderFooterImage::class;

    public function definition(): array
    {
        return [
            'image_type' => 'header',
            'file_path'  => null,
            'is_active'  => true,
        ];
    }
}
