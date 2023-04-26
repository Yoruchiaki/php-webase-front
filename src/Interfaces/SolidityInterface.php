<?php

namespace Yoruchiaki\WebaseFront\Interfaces;


interface SolidityInterface
{
    public function __construct(
        string $contractName,
        SolidityAbiInterface $solidityAbi,
        SolidityBinInterface $solidityBin,
        SoliditySolInterface $soliditySol,
        array $constructParams = []
    );

    public function getSolidityAbi(): SolidityAbiInterface;

    public function getSolidityBin(): SolidityBinInterface;

    public function getSoliditySol(): SoliditySolInterface;

    public function getContractName(): string;

    public function getConstructParams(): array;
}