<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(Pengaturan::CACHE_BINDING, fn (): Collection => Pengaturan::query()
            ->get(['key', 'value'])
            ->keyBy('key'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
