<?php

namespace App\Providers;

use App\DataTransferObjects\Factories\MessageStoreDTOFactory;
use App\DataTransferObjects\Factories\MessageStoreDTOFactoryInterface;
use App\Managers\MessageManager;
use App\Managers\MessageManagerInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MessageStoreDTOFactoryInterface::class,
            function (Container $container) {
                return new MessageStoreDTOFactory();
            }
        );

        $this->app->bind(
            MessageManagerInterface::class,
            function (Container $container) {
                return new MessageManager();
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
