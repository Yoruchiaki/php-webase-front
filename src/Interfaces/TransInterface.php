<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;
use Yoruchiaki\WebaseFront\ValueObjects\TransObject;

interface TransInterface
{
    public function handleWithSign(
        string $signUserId,
        TransObject $transObject
    ): array;

    public function handle(
        string $user,
        TransObject $transObject
    ): array;

    public function signedTransaction(string $signedStr, bool $sync): array;

    public function queryTransaction(
        string $encodeStr,
        TransObject $transObject
    ): array;

    public function signMessageHash(
        string $userAddress,
        string $hash
    ): array;

    public function convertRawTxStrWithSign(
        string $signUserId,
        TransObject $transObject,
        bool $useCns = false
    ): array;

    public function convertRawTxStrWithLocal(
        string $user,
        TransObject $transObject,
        string $contractPath = null,
        bool $useCns = false
    ): array;

    public function encodeFunction(TransObject $transObject): array;
}