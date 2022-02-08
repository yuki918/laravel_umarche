<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SampleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      app()->bind("ServiceProviderTest",function() {
          return "サービスプロバイダーのテスト";
      });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
