<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

interface Web3Interface
{
    public function getBlockNumber();

    public function getBlockByNumber(int $blockNumber);

    public function getBlockByHash(string $blockHash);

    public function getBlockTransCnt(int $blockNumber);

    public function getPbftView();

    public function getTransactionReceipt(string $transHash);

    public function getTransaction(string $transHash);

    public function getClientVersion();

    public function getCode(string $address, int $blockNumber);

    public function getTransactionTotal();

    public function getTransByBlockHashAndIndex(string $blockHash, int $transactionIndex);

    public function getTransByBlockNumberAndIndex(int $blockNumber, int $transactionIndex);

    public function getConsensusStatus();

    public function getNodeStatusList();

    public function getGroupList();

    public function getGroupPeers();

    public function getObserverList();

    public function getPeers();

    public function getPendingTransactionsCount();

    public function getSealerList();

    public function getSearch(string $inputValue = null);

    public function getSyncStatus();

    public function refresh();
}