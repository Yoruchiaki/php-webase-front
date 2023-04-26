<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;

class Solidity
{
    private SolidityAbi    $solidityAbi;
    private SolidityBin    $solidityBin;
    private SoliditySource $soliditySource;
    private string         $contractName;
    private array          $constructParams;

    /**
     * @param  string  $contractName  合约名称
     * @param  SolidityAbi  $solidityAbi  合约Abi对象 应当是 JSON 文本
     * @param  SolidityBin  $solidityBin  合约Bin对象 Runtime-Bin
     * @param  SoliditySource  $soliditySource  合约源码对象 即 *.sol文件
     * @param  array  $constructParams  合约部署构造函数传参
     */
    public function __construct(
        string $contractName,
        SolidityAbi $solidityAbi,
        SolidityBin $solidityBin,
        SoliditySource $soliditySource,
        array $constructParams = []
    ) {
        $this->contractName = $contractName;
        $this->solidityAbi = $solidityAbi;
        $this->solidityBin = $solidityBin;
        $this->soliditySource = $soliditySource;
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
     * @return SoliditySource
     */
    public function getSoliditySource(): SoliditySource
    {
        return $this->soliditySource;
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