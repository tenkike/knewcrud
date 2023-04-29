<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VkFooter;
use App\Models\VkTitle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pfooter>
 */
class VkFooterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = VkFooter::class;


    public function definition()
    {
        return [
            'id_footer'=> VkTitle::factory(),
            'f_title' => $this->faker->word(),
            'f_description' => $this->faker->text,
        ];
    }
}
