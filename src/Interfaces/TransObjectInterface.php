<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

interface TransObjectInterface
{
    public function __construct(
        string $contractAddress = '0x0',
        string $contractName = null,
        SolidityAbiInterface $contractAbi = null,
        string $funName = '',
        $funParams = []
    );

    /**
     * @return string
     */
    public function getContractAddress(): string;

    public function setContractAddress(string $contractAddress): void;

    public function getFunName(): string;

    public function setFunName(string $funName): void;


    public function getContractName(): string;


    public function setContractName(string $contractName): void;


    public function getFunParams(): array;


    public function setFunParams(array $funParams): void;


    public function getContractAbi(): SolidityAbiInterface;


    public function setContractAbi(SolidityAbiInterface $contractAbi): void;

}