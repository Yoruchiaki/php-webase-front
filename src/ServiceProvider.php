<?php

namespace Yoruchiaki\WebaseFront;

use Illuminate\Contracts\Support\DeferrableProvider;
use Yoruchiaki\WebaseFront\HttpClient\AppConfig;
use Yoruchiaki\WebaseFront\HttpClient\HttpRequest;
use Yoruchiaki\WebaseFront\Interfaces\HttpRequestInterface;
use Yoruchiaki\WebaseFront\Services\Abi\ContractService;
use Yoruchiaki\WebaseFront\Services\PrivateKey\PrivateKeyService;
use Yoruchiaki\WebaseFront\Services\Trans\TransService;

class ServiceProvider extends \Illuminate\Support\ServiceProvider implements DeferrableProvider
{
    /**
     * 引导包服务
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/webase-front.php' => config_path('webase-front.php'),
        ], ['webase-front']);
    }


    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/webase-front.php', 'webase-front'
        );
        $this->app->bind(HttpRequestInterface::class, function () {
            return new HttpRequest(
                new AppConfig(
                    config('webase-front.frontUrl'),
                    config('webase-front.timeout')
                )
            );
        });
        $this->app->singleton(ContractService::class, function ($app) {
            return new ContractService($app->make(HttpRequestInterface::class));
        });

        $this->app->singleton(TransService::class, function ($app) {
            return new TransService($app->make(HttpRequestInterface::class));
        });

        $this->app->singleton(PrivateKeyService::class, function ($app) {
            return new PrivateKeyService($app->make(HttpRequestInterface::class));
        });
        $this->app->alias(ContractService::class, 'Abi');
        $this->app->alias(TransService::class, 'Trans');
        $this->app->alias(PrivateKeyService::class, 'Pk');
    }

    public function provides(): array
    {
        return [ContractService::class, TransService::class, PrivateKeyService::class];
    }
}