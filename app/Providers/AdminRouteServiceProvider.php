<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Crud\AdminRoutes;

class AdminRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
         
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(AdminRoutes $AdminRoutes)
    {
        $this->AdminRoutes= $AdminRoutes;
        $this->AdminRoutes::init_routes();
    }
}
