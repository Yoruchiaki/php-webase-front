<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;

use Yoruchiaki\WebaseFront\Interfaces\SolidityAbiInterface;
use Yoruchiaki\WebaseFront\Interfaces\SolidityBinInterface;
use Yoruchiaki\WebaseFront\Interfaces\SolidityInterface;
use Yoruchiaki\WebaseFront\Interfaces\SoliditySolInterface;

class Solidity implements SolidityInterface
{
    private SolidityAbi $solidityAbi;
    private SolidityBin $solidityBin;
    private SoliditySol $soliditySol;
    private string      $contractName;
    private array       $constructParams;

    /**
     * @param  string  $contractName  合约名称
     * @param  SolidityAbi  $solidityAbi  合约Abi对象 应当是 JSON 文本
     * @param  SolidityBin  $solidityBin  合约Bin对象 Runtime-Bin
     * @param  SoliditySol  $soliditySol  合约源码对象 即 *.sol文件
     * @param  array  $constructParams  合约部署构造函数传参
     */
    public function __construct(
        string $contractName,
        SolidityAbiInterface $solidityAbi,
        SolidityBinInterface $solidityBin,
        SoliditySolInterface $soliditySol,
        array $constructParams = []
    ) {
        $solidityAbi->valid();
        $solidityBin->valid();
        $soliditySol->valid();
        $this->contractName = $contractName;
        $this->solidityAbi = $solidityAbi;
        $this->solidityBin = $solidityBin;
        $this->soliditySol = $soliditySol;
        $this->constructParams = $constructParams;
    }

    /**
     * @return SolidityAbi
     */
    public function getSolidityAbi(): SolidityAbi
    {
        return $this->solidityAbi;
    }

    /**
     * @return SolidityBin
     */
    public function getSolidityBin(): SolidityBin
    {
        return $this->solidityBin;
    }

    /**
     * @return SoliditySol
     */
    public function getSoliditySol(): SoliditySol
    {
        return $this->soliditySol;
    }

    /**
     * @return string
     */
    public function getContractName(): string
    {
        return $this->contractName;
    }

    /**
     * @return array
     */
    public function getConstructParams(): array
    {
        return $this->constructParams;
    }
}