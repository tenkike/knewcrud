<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VkBody;
use App\Models\VkTitle;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pbody>
 */
class VkBodyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = VkBody::class;


    public function definition()
    {
         return [
            'id_body'=> VkTitle::factory(),
            'b_title' => $this->faker->unique()->word(),
            'b_description' => $this->faker->text,
        ];
    }
}
