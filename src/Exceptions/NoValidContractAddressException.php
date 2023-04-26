<?php

namespace Yoruchiaki\WebaseFront\Exceptions;

use Exception;

class NoValidContractAddressException extends Exception
{
    protected $message = '没有有效的合约地址';
}