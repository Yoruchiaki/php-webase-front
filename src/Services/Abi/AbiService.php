<?php

namespace Yoruchiaki\WebaseFront\Services\Abi;

use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\HttpClient\HttpRequest;
use Yoruchiaki\WebaseFront\Interfaces\AbiInterface;
use Yoruchiaki\WebaseFront\Services\BaseService;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;
use Yoruchiaki\WebaseFront\ValueObjects\SoliditySource;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityBin;

class AbiService extends BaseService implements AbiInterface
{
    /**
     * @param  int  $groupId
     * @param  string  $contractName
     * @param  string  $address
     * @param  array  $abiInfo
     * @param  string  $contractBin
     *
     * @return array
     * @throws GuzzleException
     */
    public function abiInfo(
        int $groupId,
        string $contractName,
        string $address,
        array $abiInfo,
        SolidityBin $contractBin
    ): array {
        return $this->http->request('POST', 'contract/abiInfo', [
            'groupId'      => $groupId,
            'contractName' => $contractName,
            'address'      => $address,
            'contractBin'  => $contractBin,
            'abiInfo'      => $abiInfo
        ]);
    }

    /**
     * @param  int  $groupId
     * @param  string  $signUserId
     * @param  array  $abiInfo
     * @param  string  $contractBin
     * @param  string|null  $contractName
     * @param  array|null  $funcParam
     * @param  string|null  $version
     *
     * @return array
     * @throws GuzzleException
     */
    public function deployWithSign(
        int $groupId,
        string $signUserId,
        SolidityAbi $abiInfo,
        SolidityBin $contractBin,
        string $contractName = null,
        array $funcParam = [],
        string $version = null
    ): array {
        return $this->http->request('POST', 'contract/deployWithSign', [
            'groupId'     => $groupId,
            'signUserId'  => $signUserId,
            'abiInfo'     => $abiInfo->toArray(),
            'bytecodeBin' => (string) $contractBin,
            'funcParam'   => $funcParam
        ]);
    }

    /**
     * @param  int  $groupId
     * @param  string  $user
     * @param  array  $abiInfo
     * @param  string  $bytecodeBin
     * @param  string|null  $contractName
     * @param  array|null  $funcParam
     *
     * @return array
     * @throws GuzzleException
     */
    public function deploy(
        int $groupId,
        string $user,
        array $abiInfo,
        SolidityBin $bytecodeBin,
        string $contractName = null,
        array $funcParam = null
    ): array {
        return $this->http->request('POST', 'contract/deploy', [
            'groupId'      => $groupId,
            'user'         => $user,
            'contractName' => $contractName,
            'abiInfo'      => $abiInfo,
            'bytecodeBin'  => (string) $bytecodeBin,
            'funcParam'    => $funcParam,
        ]);
    }

    /**
     * @param  string  $contractName
     * @param  array  $abiInfo
     * @param  string  $contractBin
     * @param  string  $packageName
     *
     * @return array
     * @throws GuzzleException
     */
    public function compileJava(
        string $contractName,
        array $abiInfo,
        string $contractBin,
        string $packageName
    ): array {
        return $this->http->request('POST', 'contract/compile-java',
            compact(
                'contractBin',
                'contractName',
                'abiInfo',
                'packageName')
        );
    }

    /**
     * @param  int  $groupId
     * @param  string  $contractName
     * @param  string  $contractPath
     * @param  SoliditySource  $contractSource
     *
     * @param  SolidityAbi  $contractAbi
     * @param  SolidityBin  $bytecodeBin
     *
     * @return array
     * @throws GuzzleException
     */
    public function save(
        int $groupId,
        string $contractName,
        string $contractPath,
        SoliditySource $contractSource,
        SolidityAbi $contractAbi,
        SolidityBin $contractBin
    ): array {
        return $this->http->request('POST', 'contract/save',
            [
                'groupId'        => $groupId,
                'contractName'   => $contractName,
                'contractBin'    => (string) $contractBin,
                'contractPath'   => $contractPath,
                'contractAbi'    => (string) $contractAbi,
                'contractSource' => (string) $contractSource
            ]
        );
    }

    /**
     * @param  int  $groupId
     * @param  int  $contractId
     *
     * @return array
     * @throws GuzzleException
     */
    public function deleteContract(int $groupId, int $contractId): array
    {
        return $this->http->request('DELETE', "contract/$groupId/$contractId");
    }

    /**
     * @param  int  $groupId
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
        int $groupId,
        int $pageNumber,
        int $pageSize,
        string $contractName = null,
        int $contractStatus = null,
        string $contractAddress = null,
        string $contractPath = null
    ): array {
        return $this->http->request('POST', 'contract/contractList',
            [
                'groupId'         => $groupId,
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
     * @param  int  $groupId
     * @param  int  $contractId
     *
     * @return array
     * @throws GuzzleException
     */
    public function ifChanged(int $groupId, int $contractId): array
    {
        return $this->http->request('GET', "contract/ifChanged/$groupId/$contractId");
    }

    /**
     * @param  string  $contractName
     * @param  string  $solidityBase64
     *
     * @return array
     * @throws GuzzleException
     */
    public function contractCompile(string $contractName, SoliditySource $solidityBase64): array
    {
        return $this->http->request('POST', "contract/contractCompile", [
            'contractName'   => $contractName,
            'solidityBase64' => (string) $solidityBase64
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
     * @param  int  $groupId
     * @param  int  $contractStatus
     *
     * @return array
     * @throws GuzzleException
     */
    public function contractListFull(int $groupId, int $contractStatus): array
    {
        return $this->http->request('get',
            "contract/contractList/all/light",
            [
                'groupId'        => $groupId,
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
     * @param  int  $groupId
     *
     * @return array
     * @throws GuzzleException
     */
    public function findContractPathList(int $groupId): array
    {
        return $this->http->request('GET', "contract/findPathList/$groupId");
    }

    /**
     * @param  int  $groupId
     * @param  string  $contractPath
     *
     * @return array
     * @throws GuzzleException
     */
    public function addContractPath(int $groupId, string $contractPath): array
    {
        return $this->http->request('POST', "contract/addContractPath", [
            'groupId'      => $groupId,
            'contractPath' => $contractPath
        ]);
    }

    /**
     * @param  int  $groupId
     * @param  string  $contractPath
     *
     * @return array
     * @throws GuzzleException
     */
    public function deleteContractPath(int $groupId, string $contractPath): array
    {
        return $this->http->request('DELETE', "contract/deletePath/$groupId/$contractPath");
    }

    /**
     * @param  int  $groupId
     * @param  string  $contractPath
     *
     * @return array
     * @throws GuzzleException
     */
    public function deleteContractByPath(int $groupId, string $contractPath): array
    {
        return $this->http->request('DELETE', "contract/batch/$groupId/$contractPath");
    }

    /**
     * @param  int  $groupId
     * @param  string  $contractName
     * @param  string  $cnsName
     * @param  string  $contractAddress
     * @param  string  $abiInfo
     * @param  string  $version
     * @param  bool  $saveEnabled
     * @param $userAddress
     * @param $contractPath
     * @param $signUserId
     *
     * @return array
     * @throws GuzzleException
     */
    public function registerCns(
        int $groupId,
        string $contractName,
        string $cnsName,
        string $contractAddress,
        SolidityAbi $abiInfo,
        string $version,
        string $signUserId
    ): array {
        return $this->http->request('POST', "contract/registerCns",
            [
                'groupId'         => $groupId,
                'contractName'    => $contractName,
                'cnsName'         => $cnsName,
                'contractAddress' => $contractAddress,
                'abiInfo'         => $abiInfo->toArray(),
                'version'         => $version,
                'saveEnabled'     => false,
                'signUserId'      => $signUserId
            ]
        );
    }

    /**
     * @param  int  $groupId
     * @param  string  $contractAddress
     *
     * @return array
     * @throws GuzzleException
     */
    public function findCns(int $groupId, string $contractAddress): array
    {
        return $this->http->request('POST', 'contract/findCns', [
            'groupId'         => $groupId,
            'contractAddress' => $contractAddress
        ]);
    }
}