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
    );

    public function deployWithSign(
        int $groupId,
        string $signUserId,
        SolidityAbi $abiInfo,
        SolidityBin $contractBin,
        string $contractName,
        array $funcParam = [],
        string $version = null
    );

    public function deploy(
        int $groupId,
        string $user,
        array $abiInfo,
        SolidityBin $bytecodeBin,
        string $contractName = null,
        array $funcParam = null
    );

    /**
     * @return mixed
     * @deprecated
     */
    public function compileJava(string $contractName, array $abiInfo, string $contractBin, string $packageName);

    public function save(
        int $groupId,
        string $contractName,
        string $contractPath,
        SoliditySource $contractSource,
        SolidityAbi $contractAbi,
        SolidityBin $contractBin
    );

    public function deleteContract(int $groupId, int $contractId);

    public function contractList(
        int $groupId,
        int $pageNumber,
        int $pageSize,
        string $contractName = null,
        int $contractStatus = null,
        string $contractAddress = null,
        string $contractPath = null
    );

    public function ifChanged(int $groupId, int $contractId);

    public function contractCompile(string $contractName, SoliditySource $solidityBase64);

    public function multiContractCompile(string $contractZipBase64);

    public function contractListFull(int $groupId, int $contractStatus);

    public function findOne(int $contractId);

    public function findContractPathList(int $groupId);

    public function addContractPath(int $groupId, string $contractPath);

    public function deleteContractPath(int $groupId, string $contractPath);

    public function deleteContractByPath(int $groupId, string $contractPath);

    public function registerCns(
        int $groupId,
        string $contractName,
        string $cnsName,
        string $contractAddress,
        SolidityAbi $abiInfo,
        string $version,
        string $signUserId
    );

    public function findCns(int $groupId, string $contractAddress);
}