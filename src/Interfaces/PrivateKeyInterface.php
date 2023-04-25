<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

interface PrivateKeyInterface
{
    public function create(
        string $userName,
        string $signUserId,
        int $type = 2,
        string $appId = null,
        bool $returnPrivateKey = false
    );


    public function import(string $privateKey, string $userName);

    public function localKeyStores();

    public function deleteByAddress(string $address);

    public function importPem(string $pemContent, string $userName);

    public function importWithSign(string $signUserId, string $appId, string $privateKey);

    public function signMessageHash(string $signUserId, string $messageHash);

    public function exportPem(string $signUserId = null, string $userAddress = null);

    public function exportP12(string $signUserId = null, string $userAddress = null);

    public function userInfoWithSign(string $signUserId, bool $returnPrivateKey);
}