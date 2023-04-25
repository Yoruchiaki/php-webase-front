<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;

interface ToolInterface
{
    public function decode(int $decodeType, string $methodName, string $input, SolidityAbi $abiList, string $output);

    public function keypair(string $privateKey);

    public function address(string $publicKey);

    public function hash(string $input, int $type = 1);

    public function convert2Bytes32(string $input, int $type = 1);

    public function utf8ToHexString(string $input);

    public function signMsg(string $privateKey, string $rawData);
}