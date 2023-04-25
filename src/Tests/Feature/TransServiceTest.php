<?php

namespace Yoruchiaki\WebaseFront\Tests\Feature;


use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Tests\TestCase;

class TransServiceTest extends TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function SignMessageHash()
    {
        $userName = $this->faker->uuid;
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->create($userName, $signUserId, 2, $this->appId, false);
        ['signUserId' => $signUserId] = $res;
        $this->assertAllResponseKey(['signUserId'], $res);
        $res = $this->abiClient->deployWithSign(
            1,
            $signUserId,
            $this->contractAbi,
            $this->contractBin,
            $this->contractName
        );
        ['result' => $address] = $res;
        $this->assertAllResponseKey(['result'], $res);
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithSign(
            $signUserId,
            $this->contractName,
            $address,
            'set',
            $this->contractAbi,
            [$text],
        );
        $this->assertAllResponseKey(['result'], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function ConvertRawTxStrWithLocal()
    {
        $userName = $this->faker->userName();
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->create($userName, $signUserId, 2, $this->appId, true);
        ['address' => $userAddress, 'privateKey' => $privateKey] = $res;
        $res = $this->pkClient->import(base64_decode($privateKey), $userName);
        $this->assertAllResponseKey(['address', 'publicKey', 'privateKey', 'userName', 'type'], $res);
        $res = $this->abiClient->deployWithSign(
            1,
            $signUserId,
            $this->contractAbi,
            $this->contractBin,
            $this->contractName
        );
        ['result' => $contractAddress] = $res;
        $this->assertAllResponseKey(['result'], $res);
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithLocal(
            $userAddress,
            $this->contractName,
            $contractAddress,
            'set',
            $this->contractAbi,
            [$text]
        );
        $this->assertAllResponseKey(['result'], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function HandleWithSign()
    {
        $userName = $this->faker->userName();
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->create($userName, $signUserId, 2, $this->appId, false);
        ['signUserId' => $signUserId] = $res;
        $res = $this->abiClient->deployWithSign(
            1,
            $signUserId,
            $this->contractAbi,
            $this->contractBin,
            $this->contractName
        );
        ['result' => $address] = $res;
        $text = $this->faker->text(100);
        $res = $this->transClient->handleWithSign(
            $signUserId,
            1,
            $this->contractName,
            $address,
            'set',
            $this->contractAbi,
            [$text]
        );
        $this->assertAllResponseKey([
            'transactionHash',
            'transactionIndex' => "0x0",
            'root',
            'blockNumber',
            'blockHash',
            'from',
            'to',
            'gasUsed',
            'contractAddress'  => "0x0000000000000000000000000000000000000000",
            'logs',
            'logsBloom',
            'status'           => "0x0",
            'statusMsg'        => 'None',
            'input',
            "output"           => "0x",
            'txProof'          => null,
            'receiptProof'     => null,
            'message'          => 'Success',
            'statusOK'         => true,
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function SignedTransaction()
    {
        $userName = $this->faker->userName();
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->create($userName, $signUserId, 2, $this->appId, false);
        ['signUserId' => $signUserId] = $res;
        $this->assertAllResponseKey(['signUserId'], $res);
        $res = $this->abiClient->deployWithSign(
            1,
            $signUserId,
            $this->contractAbi,
            $this->contractBin,
            $this->contractName
        );
        ['result' => $address] = $res;
        $this->assertAllResponseKey(['result'], $res);
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithSign(
            $signUserId,
            $this->contractName,
            $address,
            'set',
            $this->contractAbi,
            [$text],
        );
        $this->assertAllResponseKey(['result'], $res);
        ['result' => $signedStr] = $res;
        $res = $this->transClient->signedTransaction($signedStr, true, 1);
        $this->assertAllResponseKey([
            'transactionHash',
            'transactionIndex' => "0x0",
            'root',
            'blockNumber',
            'blockHash',
            'from',
            'to',
            'gasUsed',
            'contractAddress'  => "0x0000000000000000000000000000000000000000",
            'logs',
            'logsBloom',
            'status'           => "0x0",
            'statusMsg'        => 'None',
            'input',
            "output"           => "0x",
            'txProof'          => null,
            'receiptProof'     => null,
            'message'          => 'Success',
            'statusOK'         => true,
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function Handle()
    {
        $userName = $this->faker->userName();
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->create($userName, $signUserId, 2, $this->appId, true);
        ['address' => $userAddress, 'privateKey' => $privateKey] = $res;
        $res = $this->pkClient->import(base64_decode($privateKey), $userName);
        $this->assertAllResponseKey(['address', 'publicKey', 'privateKey', 'userName', 'type'], $res);
        $res = $this->abiClient->deployWithSign(
            1,
            $signUserId,
            $this->contractAbi,
            $this->contractBin,
            $this->contractName
        );
        ['result' => $contractAddress] = $res;
        $this->assertAllResponseKey(['result'], $res);
        $text = $this->faker->text(100);
        $res = $this->transClient->handle(
            $userAddress,
            $this->contractName,
            $contractAddress,
            'set',
            $this->contractAbi,
            [$text]
        );
        $this->assertAllResponseKey([
            'transactionHash',
            'transactionIndex' => "0x0",
            'root',
            'blockNumber',
            'blockHash',
            'from',
            'to',
            'gasUsed',
            'contractAddress'  => "0x0000000000000000000000000000000000000000",
            'logs',
            'logsBloom',
            'status'           => "0x0",
            'statusMsg'        => 'None',
            'input',
            "output"           => "0x",
            'txProof'          => null,
            'receiptProof'     => null,
            'message'          => 'Success',
            'statusOK'         => true,
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function ConvertRawTxStrWithSign()
    {
        $userName = $this->faker->userName();
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->create($userName, $signUserId, 2, $this->appId, true);
        ['signUserId' => $signUserId] = $res;
        $res = $this->abiClient->deployWithSign(
            1,
            $signUserId,
            $this->contractAbi,
            $this->contractBin,
            $this->contractName
        );
        ['result' => $contractAddress] = $res;
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithSign(
            $signUserId,
            $this->contractName,
            $contractAddress,
            'set',
            $this->contractAbi,
            [$text]
        );
        $this->assertAllResponseKey(['result'], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function QueryTransaction()
    {
        $userName = $this->faker->userName();
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->create($userName, $signUserId, 2, $this->appId, true);
        ['signUserId' => $signUserId] = $res;
        $res = $this->abiClient->deployWithSign(
            1,
            $signUserId,
            $this->contractAbi,
            $this->contractBin,
            $this->contractName
        );
        ['result' => $contractAddress] = $res;
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithSign(
            $signUserId,
            $this->contractName,
            $contractAddress,
            'set',
            $this->contractAbi,
            [$text]
        );
        $this->assertAllResponseKey(['result'], $res);
        ['result' => $signedStr] = $res;
        $res = $this->transClient->queryTransaction($signedStr, $contractAddress, 1, 'set', $this->contractAbi);
        $this->assertAllResponseKey([], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function EncodeFunction()
    {
        $text = $this->faker->text();
        $res = $this->transClient->encodeFunction('set', $this->contractAbi, [$text]);
        $this->assertAllResponseKey(['result'], $res);
    }
}
