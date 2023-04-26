<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;

use Yoruchiaki\WebaseFront\Exceptions\NoValidContractAddressException;
use Yoruchiaki\WebaseFront\Exceptions\NoValidContractFunctionNameException;
use Yoruchiaki\WebaseFront\Interfaces\SolidityAbiInterface;
use Yoruchiaki\WebaseFront\Interfaces\TransObjectInterface;

class TransObject implements TransObjectInterface
{
    private string      $contractAddress;
    private string      $funName;
    private SolidityAbi $contractAbi;
    private array       $funParams;
    private string      $contractName;

    /**
     * @throws NoValidContractAddressException
     * @throws NoValidContractFunctionNameException
     */
    public function __construct(
        string $contractAddress = '0x0',
        string $contractName = null,
        SolidityAbiInterface $contractAbi = null,
        string $funName = '',
        $funParams = []
    ) {
        $this->contractName = $contractName;
        $this->contractAddress = $contractAddress;
        $this->funName = $funName;
        $this->contractAbi = $contractAbi;
        $this->funParams = $funParams;
        if (!str_starts_with($contractAddress, '0x')) {
            throw new NoValidContractAddressException();
        }
        if (!$this->contractAbi->checkFunctionName($funName)) {
            throw new NoValidContractFunctionNameException();
        };
    }

    /**
     * @return string
     */
    public function getContractAddress(): string
    {
        return $this->contractAddress;
    }

    /**
     * @param  string  $contractAddress
     */
    public function setContractAddress(string $contractAddress): void
    {
        $this->contractAddress = $contractAddress;
    }

    /**
     * @return string
     */
    public function getFunName(): string
    {
        return $this->funName;
    }

    /**
     * @param  string  $funName
     */
    public function setFunName(string $funName): void
    {
        $this->funName = $funName;
    }

    /**
     * @return string
     */
    public function getContractName(): string
    {
        return $this->contractName;
    }

    /**
     * @param  string  $contractName
     */
    public function setContractName(string $contractName): void
    {
        $this->contractName = $contractName;
    }

    /**
     * @return array
     */
    public function getFunParams(): array
    {
        return $this->funParams;
    }

    /**
     * @param  array  $funParams
     */
    public function setFunParams(array $funParams): void
    {
        $this->funParams = $funParams;
    }

    /**
     * @return SolidityAbi
     */
    public function getContractAbi(): SolidityAbi
    {
        return $this->contractAbi;
    }

    /**
     * @param  SolidityAbi  $contractAbi
     */
    public function setContractAbi(SolidityAbiInterface $contractAbi): void
    {
        $this->contractAbi = $contractAbi;
    }
}