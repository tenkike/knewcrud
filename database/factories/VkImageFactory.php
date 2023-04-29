<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VkImage;
use App\Models\VkTitle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pimage>
 */
class VkImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = VkImage::class;

    public function definition()
    {
        return [
            'id_image'=> VkTitle::factory(),
            'i_title' => $this->faker->unique()->word(),
            'i_description' => $this->faker->text
        ];
    }
}
