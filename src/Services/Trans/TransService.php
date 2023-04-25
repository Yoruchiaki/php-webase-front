<?php

namespace Yoruchiaki\WebaseFront\Services\Trans;

use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Interfaces\TransInterface;
use Yoruchiaki\WebaseFront\Services\BaseService;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;

class TransService extends BaseService implements TransInterface
{
    /**
     * @param  string  $signUserId
     * @param  int  $groupId
     * @param  string  $contractName
     * @param  string  $contractAddress
     * @param  string  $funcName
     * @param  SolidityAbi  $contractAbi
     * @param  array  $funcParam
     *
     * @return array
     * @throws GuzzleException
     */
    public function handleWithSign(
        string $signUserId,
        int $groupId,
        string $contractName,
        string $contractAddress,
        string $funcName,
        SolidityAbi $contractAbi,
        array $funcParam = []
    ): array {
        return $this->http->request('POST', 'trans/handleWithSign', [
            'signUserId'      => $signUserId,
            'groupId'         => $groupId,
            'contractAddress' => $contractAddress,
            'funcName'        => $funcName,
            'contractAbi'     => $contractAbi->toArray(),
            'funcParam'       => $funcParam
        ]);
    }

    /**
     * @param  string  $user
     * @param  string  $contractName
     * @param  string  $contractAddress
     * @param  string  $funcName
     * @param  SolidityAbi  $contractAbi
     * @param  array  $funcParam
     *
     * @return array
     * @throws GuzzleException
     */
    public function handle(
        string $user,
        string $contractName,
        string $contractAddress,
        string $funcName,
        SolidityAbi $contractAbi,
        array $funcParam = []
    ): array {
        return $this->http->request('POST', 'trans/handle', [
            'user'            => $user,
            'contractName'    => $contractName,
            'contractAddress' => $contractAddress,
            'funcName'        => $funcName,
            'contractAbi'     => $contractAbi->toArray(),
            'funcParam'       => $funcParam
        ]);
    }

    /**
     * @param  string  $signedStr
     * @param  bool  $sync
     * @param  int  $groupId
     *
     * @return array
     * @throws GuzzleException
     */
    public function signedTransaction(string $signedStr, bool $sync, int $groupId = 1): array
    {
        return $this->http->request('POST', "trans/signed-transaction", [
            'signedStr' => $signedStr,
            'sync'      => $sync,
            'groupId'   => $groupId
        ]);
    }

    /**
     * @param  string  $encodeStr
     * @param  string  $contractAddress
     * @param  string  $groupId
     * @param  string  $funcName
     * @param  SolidityAbi  $contractAbi
     * @param  string  $userAddress
     *
     * @return array
     * @throws GuzzleException
     */
    public function queryTransaction(
        string $encodeStr,
        string $contractAddress,
        string $groupId,
        string $funcName,
        SolidityAbi $contractAbi
    ): array {
        return $this->http->request('POST', 'trans/query-transaction', [
            'encodeStr'       => $encodeStr,
            'contractAddress' => $contractAddress,
            'groupId'         => $groupId,
            'funcName'        => $funcName,
            'contractAbi'     => (string) $contractAbi
        ]);
    }

    /**
     * @param  string  $user
     * @param  string  $hash
     *
     * @return array
     * @throws GuzzleException
     */
    public function signMessageHash(string $user, string $hash): array
    {
        return $this->http->request('POST', 'trans/signMessageHash', [
            'user' => $user,
            'hash' => $hash
        ]);
    }

    /**
     * @param  string  $signUserId
     * @param  string  $contractName
     * @param  string  $contractAddress
     * @param  string  $funcName
     * @param  SolidityAbi  $contractAbi
     * @param  array  $funcParam
     * @param  int  $groupId
     * @param  bool  $useCns
     *
     * @return array
     * @throws GuzzleException
     */
    public function convertRawTxStrWithSign(
        string $signUserId,
        string $contractName,
        string $contractAddress,
        string $funcName,
        SolidityAbi $contractAbi,
        array $funcParam,
        int $groupId = 1,
        bool $useCns = false
    ): array {
        return $this->http->request('POST', 'trans/convertRawTxStr/withSign', [
            'signUserId'      => $signUserId,
            'contractName'    => $contractName,
            'contractAddress' => $contractAddress,
            'funcName'        => $funcName,
            'contractAbi'     => $contractAbi->toArray(),
            'funcParam'       => $funcParam,
            'groupId'         => $groupId,
            'useCns'          => $useCns
        ]);
    }

    /**
     * @param  string  $user
     * @param  string  $contractName
     * @param  string  $contractAddress
     * @param  string  $funcName
     * @param  SolidityAbi  $contractAbi
     * @param  array  $funcParam
     * @param  int  $groupId
     * @param  string|null  $contractPath
     * @param  bool  $useCns
     *
     * @return array
     * @throws GuzzleException
     */
    public function convertRawTxStrWithLocal(
        string $user,
        string $contractName,
        string $contractAddress,
        string $funcName,
        SolidityAbi $contractAbi,
        array $funcParam,
        int $groupId = 1,
        string $contractPath = null,
        bool $useCns = false
    ): array {
        return $this->http->request('POST', 'trans/convertRawTxStr/local', [
            'user'            => $user,
            'contractName'    => $contractName,
            'contractAddress' => $contractAddress,
            'funcName'        => $funcName,
            'contractAbi'     => $contractAbi->toArray(),
            'funcParam'       => $funcParam,
            'groupId'         => $groupId,
            'contractPath'    => $contractPath,
            'useCns'          => $useCns
        ]);
    }

    /**
     * @param  string  $funcName
     * @param  SolidityAbi  $contractAbi
     * @param  array  $funcParam
     *
     * @return array
     * @throws GuzzleException
     */
    public function encodeFunction(string $funcName, SolidityAbi $contractAbi, array $funcParam): array
    {
        return $this->http->request('POST', 'trans/encodeFunction', [
            'funcName'    => $funcName,
            'contractAbi' => $contractAbi->toArray(),
            'funcParam'   => $funcParam,
        ]);
    }
}