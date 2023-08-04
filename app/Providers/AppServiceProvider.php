<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
// use App\Actions\EnsureRightTenantDatabaseConnection;
class AppServiceProvider extends ServiceProvider
{
    // use EnsureRightTenantDatabaseConnection;
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        // $this->makeCurrent();

    }
}
