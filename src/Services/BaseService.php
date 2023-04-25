<?php

namespace Yoruchiaki\WebaseFront\Services;

use Yoruchiaki\WebaseFront\HttpClient\HttpRequest;
use Yoruchiaki\WebaseFront\Interfaces\BaseServiceInterface;
use Yoruchiaki\WebaseFront\Interfaces\HttpRequestInterface;

class BaseService implements BaseServiceInterface
{
    protected HttpRequest $http;

    public function __construct(HttpRequestInterface $http)
    {
        $this->http = $http;
    }
}