<?php

namespace Yoruchiaki\WebaseFront\Exceptions;


use Exception;

class SolidityAbiConstructException extends Exception
{
    protected $message = '合约Abi参数异常';
}