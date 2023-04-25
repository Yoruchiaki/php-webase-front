<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

interface HttpRequestInterface
{
    public function request(
        string $method,
        string $url,
        array $params = []
    );
}