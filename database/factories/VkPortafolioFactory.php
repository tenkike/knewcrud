<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VkPortafolio;
use App\Models\VkCategory;
use App\Models\VkSubCategory;
use App\Models\VkBody;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VkPortafolio>
 */
class VkPortafolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = VkPortafolio::class;

    public function definition()
    {
        return [
            'id_category_port'=> VkCategory::factory(),
            'id_subcat_port' => VkSubCategory::factory(),
            'id_body_port'=> VkBody::factory(),
            'port_status'=> $this->faker->randomElement([
                '0', '1'
            ]),
            'port_title'=> $this->faker->unique()->word(),
            'port_subtitle'=> $this->faker->word(),
            'port_description'=> $this->faker->text,
            'port_nameseo'=> $this->faker->text,
        ];
    }
}
