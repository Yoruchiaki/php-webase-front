<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;

interface TransInterface
{
    public function handleWithSign(
        string $signUserId,
        int $groupId,
        string $contractName,
        string $contractAddress,
        string $funcName,
        SolidityAbi $contractAbi,
        array $funcParam = []
    ): array;

    public function handle(
        string $user,
        string $contractName,
        string $contractAddress,
        string $funcName,
        SolidityAbi $contractAbi,
        array $funcParam = []
    ): array;

    public function signedTransaction(string $signedStr, bool $sync, int $groupId = 1): array;

    public function queryTransaction(
        string $encodeStr,
        string $contractAddress,
        string $groupId,
        string $funcName,
        SolidityAbi $contractAbi
    ): array;

    public function signMessageHash(
        string $user,
        string $hash
    ): array;

    public function convertRawTxStrWithSign(
        string $signUserId,
        string $contractName,
        string $contractAddress,
        string $funcName,
        SolidityAbi $contractAbi,
        array $funcParam,
        int $groupId = 1,
        bool $useCns = false
    ): array;

    public function convertRawTxStrWithLocal(
        string $user,
        string $contractName,
        string $contractAddress,
        string $funcName,
        SolidityAbi $contractAbi,
        array $funcParam,
        int $groupId = 1,
        string $contractPath = null,
        bool $useCns = false
    ): array;

    public function encodeFunction(string $funcName, SolidityAbi $contractAbi, array $funcParam): array;
}