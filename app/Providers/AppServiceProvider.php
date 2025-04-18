<?php

namespace App\Providers;

use App\Models\User;
use App\Repository\ComputerRepository;
use App\Repository\UserRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, function (Application $app){
            return new UserRepository();
        });

        $this->app->singleton(ComputerRepository::class, function (Application $app) {
            return new ComputerRepository($app->make(UserRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Example register directive Blade
        Blade::directive('ifGuest', function () {
            return "<?php if (auth()->guest()):?>";
        });
    }
}
