<?php

namespace Yoruchiaki\WebaseFront\Services;

use Yoruchiaki\WebaseFront\HttpClient\HttpRequest;
use Yoruchiaki\WebaseFront\Interfaces\BaseServiceInterface;
use Yoruchiaki\WebaseFront\Interfaces\HttpRequestInterface;

abstract class BaseService implements BaseServiceInterface
{
    protected HttpRequest $http;

    protected int $groupId = 1;

    public function __construct(HttpRequestInterface $http)
    {
        $this->http = $http;
    }

    public function setGroupId(int $groupId): BaseService
    {
        $this->groupId = $groupId;
        return $this;
    }
}