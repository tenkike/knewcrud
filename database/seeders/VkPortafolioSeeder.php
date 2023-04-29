<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VkBody;
use App\Models\VkPortafolio;

class VkPortafolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $model = VkPortafolio::class;

    public function run()
    {
        VkPortafolio::factory(30)->create();
    }
}
