<?php

namespace Yoruchiaki\WebaseFront\Services\Abi;

use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Interfaces\ContractInterface;
use Yoruchiaki\WebaseFront\Services\BaseService;
use Yoruchiaki\WebaseFront\ValueObjects\Solidity;
use Yoruchiaki\WebaseFront\ValueObjects\SoliditySol;

class ContractService extends BaseService implements ContractInterface
{
    /**
     * @param  Solidity  $solidity  合约对象
     * @param  string  $contractAddress  合约地址
     *
     * @return array
     * @throws GuzzleException
     */
    public function abiInfo(
        Solidity $solidity,
        string $contractAddress
    ): array {
        return $this->http->request('POST', 'contract/abiInfo', [
            'groupId'      => $this->groupId,
            'contractName' => $solidity->getContractName(),
            'address'      => $contractAddress,
            'contractBin'  => $solidity->getSolidityBin(),
            'abiInfo'      => $solidity->getSolidityAbi()->toArray()
        ]);
    }

    /**
     * @param  string  $signUserId
     * @param  Solidity  $solidity
     * @param  string|null  $version
     *
     * @return array
     * @throws GuzzleException
     */
    public function deployWithSign(
        string $signUserId,
        Solidity $solidity,
        string $version = null
    ): array {
        return $this->http->request('POST', 'contract/deployWithSign', [
            'groupId'     => $this->groupId,
            'signUserId'  => $signUserId,
            'abiInfo'     => $solidity->getSolidityAbi()->toArray(),
            'bytecodeBin' => $solidity->getSolidityBin()->toString(),
            'funcParam'   => $solidity->getConstructParams()
        ]);
    }

    /**
     * @param  string  $user
     * @param  Solidity  $solidity
     *
     * @return array
     * @throws GuzzleException
     */
    public function deploy(
        string $user,
        Solidity $solidity
    ): array {
        return $this->http->request('POST', 'contract/deploy', [
            'groupId'      => $this->groupId,
            'user'         => $user,
            'contractName' => $solidity->getContractName(),
            'abiInfo'      => $solidity->getSolidityAbi()->toArray(),
            'bytecodeBin'  => $solidity->getSolidityBin()
        ]);
    }

    /**
     * @param  Solidity  $solidity
     * @param  string  $packageName
     *
     * @return array
     * @throws GuzzleException
     */
    public function compileJava(
        Solidity $solidity,
        string $packageName
    ): array {
        return $this->http->request('POST', 'contract/compile-java',
            [
                'contractBin'  => $solidity->getSolidityBin()->toString(),
                'contractName' => $solidity->getContractName(),
                'abiInfo'      => $solidity->getSolidityAbi()->toArray(),
                'packageName'  => $packageName
            ]
        );
    }

    /**
     * @param  Solidity  $solidity
     * @param  string  $contractPath
     *
     * @return array
     * @throws GuzzleException
     */
    public function save(
        Solidity $solidity,
        string $contractPath
    ): array {
        return $this->http->request('POST', 'contract/save',
            [
                'groupId'        => $this->groupId,
                'contractName'   => $solidity->getContractName(),
                'contractBin'    => $solidity->getSolidityBin()->toString(),
                'contractPath'   => $contractPath,
                'contractAbi'    => $solidity->getSolidityAbi()->toString(),
                'contractSource' => $solidity->getSoliditySol()->toString()
            ]
        );
    }

    /**
     * @param  int  $contractId
     *
     * @return array
     * @throws GuzzleException
     */
    public function deleteContract(int $contractId): array
    {
        return $this->http->request('DELETE', "contract/$this->groupId/$contractId");
    }

    /**
     * @param  int  $pageNumber
     * @param  int  $pageSize
     * @param  string|null  $contractName
     * @param  int|null  $contractStatus
     * @param  string|null  $contractAddress
     * @param  string|null  $contractPath
     *
     * @return array
     * @throws GuzzleException
     */
    public function contractList(
        int $pageNumber = 1,
        int $pageSize = 10,
        string $contractName = null,
        int $contractStatus = null,
        string $contractAddress = null,
        string $contractPath = null
    ): array {
        return $this->http->request('POST', 'contract/contractList',
            [
                'groupId'         => $this->groupId,
                'pageNumber'      => $pageNumber,
                'pageSize'        => $pageSize,
                'contractName'    => $contractName,
                'contractStatus'  => $contractStatus,
                'contractAddress' => $contractAddress,
                'contractPath'    => $contractPath
            ]
        );
    }

    /**
     * @param  int  $contractId
     *
     * @return array
     * @throws GuzzleException
     */
    public function ifChanged(int $contractId): array
    {
        return $this->http->request('GET', "contract/ifChanged/$this->groupId/$contractId");
    }

    /**
     * @param  string  $contractName
     * @param  SoliditySol  $soliditySource
     *
     * @return array
     * @throws GuzzleException
     */
    public function contractCompile(string $contractName, SoliditySol $soliditySource): array
    {
        return $this->http->request('POST', "contract/contractCompile", [
            'contractName'   => $contractName,
            'solidityBase64' => $soliditySource->toString()
        ]);
    }

    /**
     * @param  string  $contractZipBase64
     *
     * @return array
     * @throws GuzzleException
     */
    public function multiContractCompile(string $contractZipBase64): array
    {
        return $this->http->request('POST', "contract/multiContractCompile", [
            'contractZipBase64' => $contractZipBase64
        ]);
    }

    /**
     * @param  int  $contractStatus
     *
     * @return array
     * @throws GuzzleException
     */
    public function contractListFull(int $contractStatus): array
    {
        return $this->http->request('get',
            "contract/contractList/all/light",
            [
                'groupId'        => $this->groupId,
                'contractStatus' => $contractStatus
            ]
        );
    }

    /**
     * @param  int  $contractId
     *
     * @return array
     * @throws GuzzleException
     */
    public function findOne(int $contractId): array
    {
        return $this->http->request('get', "contract/findOne/$contractId");
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function findContractPathList(): array
    {
        return $this->http->request('GET', "contract/findPathList/$this->groupId");
    }

    /**
     * @param  string  $contractPath
     *
     * @return array
     * @throws GuzzleException
     */
    public function addContractPath(string $contractPath): array
    {
        return $this->http->request('POST', "contract/addContractPath", [
            'groupId'      => $this->groupId,
            'contractPath' => $contractPath
        ]);
    }

    /**
     * @param  string  $contractPath
     *
     * @return array
     * @throws GuzzleException
     */
    public function deleteContractPath(string $contractPath): array
    {
        return $this->http->request('DELETE', "contract/deletePath/$this->groupId/$contractPath");
    }

    /**
     * @param  string  $contractPath
     *
     * @return array
     * @throws GuzzleException
     */
    public function deleteContractByPath(string $contractPath): array
    {
        return $this->http->request('DELETE', "contract/batch/$this->groupId/$contractPath");
    }

    /**
     * @param  Solidity  $solidity
     * @param  string  $contractAddress
     * @param  string  $cnsName
     * @param  string  $version
     * @param  string  $signUserId
     *
     * @return array
     * @throws GuzzleException
     */
    public function registerCns(
        Solidity $solidity,
        string $contractAddress,
        string $cnsName,
        string $version,
        string $signUserId
    ): array {
        return $this->http->request('POST', "contract/registerCns",
            [
                'groupId'         => $this->groupId,
                'contractName'    => $solidity->getContractName(),
                'cnsName'         => $cnsName,
                'contractAddress' => $contractAddress,
                'abiInfo'         => $solidity->getSolidityAbi()->toArray(),
                'version'         => $version,
                'saveEnabled'     => false,
                'signUserId'      => $signUserId
            ]
        );
    }

    /**
     * @param  string  $contractAddress
     *
     * @return array
     * @throws GuzzleException
     */
    public function findCns(string $contractAddress): array
    {
        return $this->http->request('POST', 'contract/findCns', [
            'groupId'         => $this->groupId,
            'contractAddress' => $contractAddress
        ]);
    }
}