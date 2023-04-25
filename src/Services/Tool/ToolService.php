<?php

namespace Yoruchiaki\WebaseFront\Services\Tool;

use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Interfaces\ToolInterface;
use Yoruchiaki\WebaseFront\Services\BaseService;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;

class ToolService extends BaseService implements ToolInterface
{

    /**
     * @param  int  $decodeType
     * @param  string  $methodName
     * @param  string  $input
     * @param  SolidityAbi  $abiList
     *
     * @return array
     * @throws GuzzleException
     */
    public function decode(
        int $decodeType,
        string $methodName,
        string $input,
        SolidityAbi $abiList,
        string $output
    ): array {
        return $this->http->request('POST', 'tool/decode', [
            'decodeType' => $decodeType,
            'methodName' => $methodName,
            'input'      => $input,
            'abiList'    => $abiList->toArray(),
            'output'     => $output
        ]);
    }

    /**
     * @param  string  $privateKey
     *
     * @return array
     * @throws GuzzleException
     */
    public function keypair(string $privateKey): array
    {
        return $this->http->request('POST', 'tool/keypair', [
            'privateKey' => $privateKey
        ]);
    }

    /**
     * @param  string  $publicKey
     *
     * @return array
     * @throws GuzzleException
     */
    public function address(string $publicKey): array
    {
        return $this->http->request('GET', 'tool/address', [
            'publicKey' => $publicKey
        ]);
    }

    /**
     * @param  string  $input
     * @param  int  $type
     *
     * @return array
     * @throws GuzzleException
     */
    public function hash(string $input, int $type = 1): array
    {
        return $this->http->request('GET', 'tool/hash', [
            'input' => $input,
            'type'  => $type
        ]);
    }

    /**
     * @param  string  $input
     * @param  int  $type
     *
     * @return array
     * @throws GuzzleException
     */
    public function convert2Bytes32(string $input, int $type = 1): array
    {
        return $this->http->request('GET', 'tool/convert2Bytes32', [
            'input' => $input,
            'type'  => $type
        ]);
    }

    /**
     * @param  string  $input
     *
     * @return array
     * @throws GuzzleException
     */
    public function utf8ToHexString(string $input): array
    {
        return $this->http->request('GET', 'tool/utf8ToHexString', [
            'input' => $input
        ]);
    }

    /**
     * @param  string  $privateKey
     * @param  string  $rawData
     *
     * @return array
     * @throws GuzzleException
     */
    public function signMsg(string $privateKey, string $rawData): array
    {
        return $this->http->request('POST', 'tool/signMsg', [
            'privateKey' => $privateKey,
            'rawData'    => $rawData
        ]);
    }
}