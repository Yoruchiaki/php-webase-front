<?php

namespace Yoruchiaki\WebaseFront\Exceptions;

use Exception;

class NoValidContractFunctionNameException extends Exception
{
    protected $message = '不是有效的合约方法';
}