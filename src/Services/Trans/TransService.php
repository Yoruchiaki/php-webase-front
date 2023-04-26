<?php

namespace Yoruchiaki\WebaseFront\Services\Trans;

use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Interfaces\TransInterface;
use Yoruchiaki\WebaseFront\Services\BaseService;
use Yoruchiaki\WebaseFront\ValueObjects\TransObject;

class TransService extends BaseService implements TransInterface
{
    /**
     * @param  string  $signUserId
     * @param  TransObject  $transObject
     *
     * @return array
     * @throws GuzzleException
     */
    public function handleWithSign(
        string $signUserId,
        TransObject $transObject
    ): array {
        return $this->http->request('POST', 'trans/handleWithSign', [
            'signUserId'      => $signUserId,
            'groupId'         => $this->groupId,
            'contractAddress' => $transObject->getContractAddress(),
            'funcName'        => $transObject->getFunName(),
            'contractAbi'     => $transObject->getContractAbi()->toArray(),
            'funcParam'       => $transObject->getFunParams()
        ]);
    }

    /**
     * @param  string  $user
     * @param  TransObject  $transObject
     *
     * @return array
     * @throws GuzzleException
     */
    public function handle(
        string $user,
        TransObject $transObject
    ): array {
        return $this->http->request('POST', 'trans/handle', [
            'user'            => $user,
            'contractName'    => $transObject->getContractName(),
            'contractAddress' => $transObject->getContractAddress(),
            'funcName'        => $transObject->getFunName(),
            'contractAbi'     => $transObject->getContractAbi()->toArray(),
            'funcParam'       => $transObject->getFunParams()
        ]);
    }

    /**
     * @param  string  $signedStr
     * @param  bool  $sync
     *
     * @return array
     * @throws GuzzleException
     */
    public function signedTransaction(string $signedStr, bool $sync): array
    {
        return $this->http->request('POST', "trans/signed-transaction", [
            'signedStr' => $signedStr,
            'sync'      => $sync,
            'groupId'   => $this->groupId
        ]);
    }

    /**
     * @param  string  $encodeStr
     * @param  TransObject  $transObject
     *
     * @return array
     * @throws GuzzleException
     */
    public function queryTransaction(
        string $encodeStr,
        TransObject $transObject
    ): array {
        return $this->http->request('POST', 'trans/query-transaction', [
            'encodeStr'       => $encodeStr,
            'contractAddress' => $transObject->getContractAddress(),
            'groupId'         => $this->groupId,
            'funcName'        => $transObject->getFunName(),
            'contractAbi'     => $transObject->getContractAbi()->toString()
        ]);
    }

    /**
     * @param  string  $userAddress
     * @param  string  $hash
     *
     * @return array
     * @throws GuzzleException
     */
    public function signMessageHash(string $userAddress, string $hash): array
    {
        return $this->http->request('POST', 'trans/signMessageHash', [
            'user' => $userAddress,
            'hash' => $hash
        ]);
    }

    /**
     * @param  string  $signUserId
     * @param  TransObject  $transObject
     * @param  bool  $useCns
     *
     * @return array
     * @throws GuzzleException
     */
    public function convertRawTxStrWithSign(
        string $signUserId,
        TransObject $transObject,
        bool $useCns = false
    ): array {
        return $this->http->request('POST', 'trans/convertRawTxStr/withSign', [
            'signUserId'      => $signUserId,
            'contractName'    => $transObject->getContractName(),
            'contractAddress' => $transObject->getContractAddress(),
            'funcName'        => $transObject->getFunName(),
            'contractAbi'     => $transObject->getContractAbi()->toArray(),
            'funcParam'       => $transObject->getFunParams(),
            'groupId'         => $this->groupId,
            'useCns'          => $useCns
        ]);
    }

    /**
     * @param  string  $user
     * @param  TransObject  $transObject
     * @param  string|null  $contractPath
     * @param  bool  $useCns
     *
     * @return array
     * @throws GuzzleException
     */
    public function convertRawTxStrWithLocal(
        string $user,
        TransObject $transObject,
        string $contractPath = null,
        bool $useCns = false
    ): array {
        return $this->http->request('POST', 'trans/convertRawTxStr/local', [
            'user'            => $user,
            'contractName'    => $transObject->getContractName(),
            'contractAddress' => $transObject->getContractAddress(),
            'funcName'        => $transObject->getFunName(),
            'contractAbi'     => $transObject->getContractAbi()->toArray(),
            'funcParam'       => $transObject->getFunParams(),
            'groupId'         => $this->groupId,
            'contractPath'    => $contractPath,
            'useCns'          => $useCns
        ]);
    }

    /**
     * @param  TransObject  $transObject
     *
     * @return array
     * @throws GuzzleException
     */
    public function encodeFunction(
        TransObject $transObject
    ): array {
        return $this->http->request('POST', 'trans/encodeFunction', [
            'funcName'    => $transObject->getFunName(),
            'contractAbi' => $transObject->getContractAbi()->toArray(),
            'funcParam'   => $transObject->getFunParams(),
        ]);
    }
}