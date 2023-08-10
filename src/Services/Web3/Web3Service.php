<?php

namespace Yoruchiaki\WebaseFront\Services\Web3;

use Yoruchiaki\WebaseFront\Interfaces\Web3Interface;
use Yoruchiaki\WebaseFront\Services\BaseService;

class Web3Service extends BaseService implements Web3Interface
{

    public function getBlockNumber(): array
    {
        return $this->http->request('GET', $this->groupId . '/web3/blockNumber');
    }

    public function getBlockByNumber(int $blockNumber): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/blockByNumber/$blockNumber");
    }

    public function getBlockByHash(string $blockHash): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/blockByHash/${blockHash}");
    }

    public function getBlockTransCnt(int $blockNumber): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/blockTransCnt/${blockNumber}");
    }

    public function getPbftView(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/pbftView");
    }

    public function getTransactionReceipt(string $transHash): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/transactionReceipt/${transHash}");
    }

    public function getTransaction(string $transHash): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/transaction/${transHash}");
    }

    public function getClientVersion(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/clientVersion");
    }

    public function getCode(string $address, int $blockNumber): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/code/${address}/${blockNumber}");
    }

    public function getTransactionTotal(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/transaction-total");
    }

    public function getTransByBlockHashAndIndex(string $blockHash, int $transactionIndex): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/transByBlockHashAndIndex/${blockHash}/${transactionIndex}");
    }

    public function getTransByBlockNumberAndIndex(int $blockNumber, int $transactionIndex): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/transByBlockNumberAndIndex/{blockNumber}/{transactionIndex}");
    }

    public function getConsensusStatus(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/consensusStatus");
    }

    public function getNodeStatusList(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/getNodeStatusList");

    }

    public function getGroupList(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/groupList");
    }

    public function getGroupPeers(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/groupPeers");
    }

    public function getObserverList(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/observerList");
    }

    public function getPeers(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/peers");
    }

    public function getPendingTransactionsCount(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/pending-transactions-count");
    }

    public function getSealerList(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/sealerList");
    }

    public function getSearch(string $inputValue = null): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/search?input=${inputValue}");
    }

    public function getSyncStatus(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/syncStatus");
    }

    public function refresh(): array
    {
        return $this->http->request('GET', $this->groupId . "/web3/refresh");
    }
}