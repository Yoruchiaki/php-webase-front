<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

use Yoruchiaki\WebaseFront\ValueObjects\Solidity;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;
use Yoruchiaki\WebaseFront\ValueObjects\SoliditySol;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityBin;
use Yoruchiaki\WebaseFront\ValueObjects\TransObject;

interface AbiInterface
{
    public function abiInfo(
        Solidity $solidity,
        string $contractAddress
    ): array;

    public function deployWithSign(
        string $signUserId,
        Solidity $solidity,
        string $version = null
    ): array;

    public function deploy(
        string $user,
        Solidity $solidity
    ): array;

    /**
     * @return mixed
     * @deprecated
     */
    public function compileJava(
        Solidity $solidity,
        string $packageName
    ): array;

    public function save(
        Solidity $solidity,
        string $contractPath
    ): array;

    public function deleteContract(int $contractId): array;

    public function contractList(
        int $pageNumber = 1,
        int $pageSize = 10,
        string $contractName = null,
        int $contractStatus = null,
        string $contractAddress = null,
        string $contractPath = null
    ): array;

    public function ifChanged(int $contractId): array;

    public function contractCompile(string $contractName, SoliditySol $soliditySource): array;

    public function multiContractCompile(string $contractZipBase64): array;

    public function contractListFull(int $contractStatus): array;

    public function findOne(int $contractId): array;

    public function findContractPathList(): array;

    public function addContractPath(string $contractPath): array;

    public function deleteContractPath(string $contractPath): array;

    public function deleteContractByPath(string $contractPath): array;

    public function registerCns(
        Solidity $solidity,
        string $contractAddress,
        string $cnsName,
        string $version,
        string $signUserId
    ): array;

    public function findCns(string $contractAddress): array;
}