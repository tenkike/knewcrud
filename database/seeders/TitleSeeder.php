<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\VkTitle;
use App\Models\VkBody;
use App\Models\VkPortafolio;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $model = VkTitle::class;

    public function run()
    {
           

           VkTitle::factory()->count(10)
            ->hasBody()
            ->hasHeader()
            ->hasFooter()
            ->hasImages()
            ->create();

            VkBody::factory()->count(10)
                ->hasPortafolio()
                ->create();

           /* Seed the relation with one address
            $pbodys = factory(Pbody::class, 5)->make();
            $ptitle->Body()->saveMany($pbodys);

            $pheaders = factory(Pheader::class)->make();
            $ptitle->Header()->save($pheaders);

            $pfooter = factory(Pfooter::class)->make();
            $ptitle->Footer()->save($pfooter);

            $pimage = factory(Pimage::class, 10)->make();
            $ptitle->Images()->saveMany($pimage);*/

       
    }
}
