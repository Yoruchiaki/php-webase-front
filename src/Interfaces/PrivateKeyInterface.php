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
    ): array;


    public function import(string $privateKey, string $userName): array;

    public function localKeyStores(): array;

    public function deleteByAddress(string $address): array;

    public function importPem(string $pemContent, string $userName): array;

    public function importWithSign(string $signUserId, string $appId, string $privateKey): array;

    public function signMessageHash(string $signUserId, string $messageHash): array;

    public function exportPem(string $signUserId = null, string $userAddress = null): array;

    public function exportP12(string $signUserId = null, string $userAddress = null): array;

    public function userInfoWithSign(string $signUserId, bool $returnPrivateKey): array;
}