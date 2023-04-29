<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VkHeader;
use App\Models\VkTitle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pheader>
 */
class VkHeaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = VkHeader::class;

    public function definition()
    {
        return [
            'id_header'=> VkTitle::factory(),
            'h_title' => $this->faker->unique()->word(),
            'h_description' => $this->faker->text,
        ];
    }
}
