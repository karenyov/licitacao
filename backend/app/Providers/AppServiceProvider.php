<?php

namespace App\Providers;

use App\Mocks\LicitacaoItemScraperMock;
use App\Services\LicitacaoItemScraperService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->bind(LicitacaoItemScraperService::class, fn () => new LicitacaoItemScraperMock());
        } else {
            $this->app->bind(LicitacaoItemScraperService::class, function () {
                $client = \Symfony\Component\HttpClient\HttpClient::create();
                return new LicitacaoItemScraperService($client);
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
