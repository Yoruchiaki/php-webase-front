<?php

namespace Yoruchiaki\WebaseFront\Facade;

use Illuminate\Support\Facades\Facade;
use Yoruchiaki\WebaseFront\Services\Contract\ContractService;
use Yoruchiaki\WebaseFront\Services\PrivateKey\PrivateKeyService;
use Yoruchiaki\WebaseFront\Services\Trans\TransService;

class TransFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TransService::class;
    }
}