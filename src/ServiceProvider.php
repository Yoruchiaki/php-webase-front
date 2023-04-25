<?php

namespace Yoruchiaki\WebaseFront;

use Yoruchiaki\WebaseFront\HttpClient\AppConfig;
use Yoruchiaki\WebaseFront\HttpClient\HttpRequest;
use Yoruchiaki\WebaseFront\Services\Abi\AbiService;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

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
        $httpClient = new HttpRequest(
            new AppConfig(
                config('webase-front.frontUrl'),
                config('webase-front.timeout')
            )
        );
        $this->app->singleton(AbiService::class, function () use ($httpClient) {
            return new AbiService($httpClient);
        });
        $this->app->alias(AbiService::class, 'Abi');
    }

    public function provides(): array
    {
        return [AbiService::class, 'Abi'];
    }
}