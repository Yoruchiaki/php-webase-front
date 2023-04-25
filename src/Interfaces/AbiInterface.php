<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;
use Yoruchiaki\WebaseFront\ValueObjects\SoliditySource;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityBin;

interface AbiInterface
{
    public function abiInfo(
        int $groupId,
        string $contractName,
        string $address,
        array $abiInfo,
        SolidityBin $contractBin
    ): array;

    public function deployWithSign(
        int $groupId,
        string $signUserId,
        SolidityAbi $abiInfo,
        SolidityBin $contractBin,
        string $contractName,
        array $funcParam = [],
        string $version = null
    ): array;

    public function deploy(
        int $groupId,
        string $user,
        array $abiInfo,
        SolidityBin $bytecodeBin,
        string $contractName = null,
        array $funcParam = null
    ): array;

    /**
     * @return mixed
     * @deprecated
     */
    public function compileJava(string $contractName, array $abiInfo, string $contractBin, string $packageName): array;

    public function save(
        int $groupId,
        string $contractName,
        string $contractPath,
        SoliditySource $contractSource,
        SolidityAbi $contractAbi,
        SolidityBin $contractBin
    ): array;

    public function deleteContract(int $groupId, int $contractId): array;

    public function contractList(
        int $groupId,
        int $pageNumber,
        int $pageSize,
        string $contractName = null,
        int $contractStatus = null,
        string $contractAddress = null,
        string $contractPath = null
    ): array;

    public function ifChanged(int $groupId, int $contractId): array;

    public function contractCompile(string $contractName, SoliditySource $solidityBase64): array;

    public function multiContractCompile(string $contractZipBase64): array;

    public function contractListFull(int $groupId, int $contractStatus): array;

    public function findOne(int $contractId): array;

    public function findContractPathList(int $groupId): array;

    public function addContractPath(int $groupId, string $contractPath): array;

    public function deleteContractPath(int $groupId, string $contractPath): array;

    public function deleteContractByPath(int $groupId, string $contractPath): array;

    public function registerCns(
        int $groupId,
        string $contractName,
        string $cnsName,
        string $contractAddress,
        SolidityAbi $abiInfo,
        string $version,
        string $signUserId
    ): array;

    public function findCns(int $groupId, string $contractAddress): array;
}