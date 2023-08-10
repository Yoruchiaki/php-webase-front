<?php

namespace Yoruchiaki\WebaseFront\Facade;

use Illuminate\Support\Facades\Facade;
use Yoruchiaki\WebaseFront\Services\Contract\ContractService;
use Yoruchiaki\WebaseFront\Services\PrivateKey\PrivateKeyService;
use Yoruchiaki\WebaseFront\Services\Trans\TransService;
use Yoruchiaki\WebaseFront\Services\Web3\Web3Service;

class Web3Facade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Web3Service::class;
    }
}