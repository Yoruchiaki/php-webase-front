<?php

namespace Yoruchiaki\WebaseFront\Facade;

use Illuminate\Support\Facades\Facade;
use Yoruchiaki\WebaseFront\Services\Abi\ContractService;
use Yoruchiaki\WebaseFront\Services\PrivateKey\PrivateKeyService;
use Yoruchiaki\WebaseFront\Services\Tool\ToolService;
use Yoruchiaki\WebaseFront\Services\Trans\TransService;

class ToolFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ToolService::class;
    }
}