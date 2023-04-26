<?php

namespace Yoruchiaki\WebaseFront\Facade;

use Illuminate\Support\Facades\Facade;
use Yoruchiaki\WebaseFront\Services\Contract\ContractService;
use Yoruchiaki\WebaseFront\Services\PrivateKey\PrivateKeyService;

class PrivateKeyFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PrivateKeyService::class;
    }
}