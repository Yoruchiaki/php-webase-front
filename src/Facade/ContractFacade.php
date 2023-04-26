<?php

namespace Yoruchiaki\WebaseFront\Facade;

use Illuminate\Support\Facades\Facade;
use Yoruchiaki\WebaseFront\Services\Contract\ContractService;

class ContractFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ContractService::class;
    }
}