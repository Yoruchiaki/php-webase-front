<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;

interface ToolInterface
{
    public function decode(int $decodeType, string $methodName, string $input, SolidityAbi $contractAbi, string $output): array;

    public function keypair(string $privateKey): array;

    public function address(string $publicKey): array;

    public function hash(string $input, int $type = 1): array;

    public function convert2Bytes32(string $input, int $type = 1): array;

    public function utf8ToHexString(string $input): array;

    public function signMsg(string $privateKey, string $rawData): array;
}