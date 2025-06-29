<?php

namespace App\Providers;

use App\Contracts\Permissions\PermissionInterface;
use App\Contracts\Roles\RoleInterface;
use App\Contracts\Statuses\StatusInterface;
use App\Contracts\UserInterface;
use App\Repositories\EloquentPermissionRepository;
use App\Repositories\EloquentRoleRepository;
use App\Repositories\EloquentStatusRepository;
use App\Repositories\EloquentUserRepository;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StatusInterface::class, EloquentStatusRepository::class);
        $this->app->bind(RoleInterface::class, EloquentRoleRepository::class);
        $this->app->bind(PermissionInterface::class, EloquentPermissionRepository::class);
        $this->app->bind(UserInterface::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModels();
        $this->configureDates();
        $this->configureVite();
    }

    /**
     * Configure the application's commands.
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction(),
        );
    }

    /**
     * Configure the application's dates.
     */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Configure the application's models.
     */
    private function configureModels(): void
    {
        Model::unguard();
        Model::shouldBeStrict();
    }

    /**
     * Configure the application's Vite instance.
     */
    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }
}
