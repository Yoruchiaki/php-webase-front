<?php

namespace Yoruchiaki\WebaseFront\Services\PrivateKey;

use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Interfaces\PrivateKeyInterface;
use Yoruchiaki\WebaseFront\Services\BaseService;

class PrivateKeyService extends BaseService implements PrivateKeyInterface
{
    /**
     * @param  string  $userName
     * @param  string  $signUserId
     * @param  int  $type
     * @param  string|null  $appId
     * @param  bool  $returnPrivateKey
     *
     * @return array
     * @throws GuzzleException
     */
    public function create(
        string $userName,
        string $signUserId,
        int $type = 2,
        string $appId = null,
        bool $returnPrivateKey = false
    ): array {
        return $this->http->request('GET', 'privateKey', [
            'userName'         => $userName,
            'signUserId'       => $signUserId,
            'type'             => $type,
            'appId'            => $appId,
            'returnPrivateKey' => $returnPrivateKey
        ]);
    }

    /**
     * @param  string  $privateKey
     * @param  string  $userName
     *
     * @return array
     * @throws GuzzleException
     */
    public function import(string $privateKey, string $userName): array
    {
        return $this->http->request('GET', 'privateKey/import', [
            'privateKey' => $privateKey,
            'userName'   => $userName
        ]);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function localKeyStores(): array
    {
        return $this->http->request('GET', 'privateKey/localKeyStores');
    }

    /**
     * @param  string  $address
     *
     * @return array
     * @throws GuzzleException
     */
    public function deleteByAddress(string $address): array
    {
        return $this->http->request('DELETE', "privateKey/$address");
    }

    /**
     * @param  string  $pemContent
     * @param  string  $userName
     *
     * @return array
     * @throws GuzzleException
     */
    public function importPem(string $pemContent, string $userName): array
    {
        return $this->http->request('POST', 'privateKey/importPem', [
            'pemContent' => $pemContent,
            'userName'   => $userName
        ]);
    }

    /**
     * @param  string  $signUserId
     * @param  string  $appId
     * @param  string  $privateKey
     *
     * @return array
     * @throws GuzzleException
     */
    public function importWithSign(string $signUserId, string $appId, string $privateKey): array
    {
        return $this->http->request('POST', 'privateKey/importWithSign', [
            'signUserId' => $signUserId,
            'appId'      => $appId,
            'privateKey' => $privateKey
        ]);
    }

    /**
     * @param  string  $signUserId
     * @param  string  $messageHash
     *
     * @return array
     * @throws GuzzleException
     */
    public function signMessageHash(string $signUserId, string $messageHash): array
    {
        return $this->http->request('POST', 'privateKey/signMessageHash', [
            'signUserId'  => $signUserId,
            'messageHash' => $messageHash
        ]);
    }

    /**
     * @param  string|null  $signUserId
     * @param  string|null  $userAddress
     *
     * @return array
     * @throws GuzzleException
     */
    public function exportPem(string $signUserId = null, string $userAddress = null): array
    {
        return $this->http->request('POST', 'privateKey/exportPem', [
            'signUserId'  => $signUserId,
            'messageHash' => $userAddress
        ]);
    }

    /**
     * @param  string|null  $signUserId
     * @param  string|null  $userAddress
     *
     * @return array
     * @throws GuzzleException
     */
    public function exportP12(string $signUserId = null, string $userAddress = null): array
    {
        return $this->http->request('POST', 'privateKey/exportPem', [
            'signUserId'  => $signUserId,
            'messageHash' => $userAddress
        ]);
    }

    /**
     * @param  string  $signUserId
     * @param  bool  $returnPrivateKey
     *
     * @return array
     * @throws GuzzleException
     */
    public function userInfoWithSign(string $signUserId, bool $returnPrivateKey): array
    {
        return $this->http->request('GET', 'privateKey/userInfoWithSign', [
            'signUserId'       => $signUserId,
            'returnPrivateKey' => $returnPrivateKey
        ]);
    }
}