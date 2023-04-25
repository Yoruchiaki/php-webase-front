<?php

namespace Yoruchiaki\WebaseFront\Facade;

use Illuminate\Support\Facades\Facade;
use Yoruchiaki\WebaseFront\Services\Abi\AbiService;

class AbiFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AbiService::class;
    }
}