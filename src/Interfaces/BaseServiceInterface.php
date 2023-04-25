<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

interface BaseServiceInterface
{
    public function __construct(HttpRequestInterface $http);
}