<?php

namespace Yoruchiaki\WebaseFront\Tests\Feature;


use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Exceptions\NoValidContractAddressException;
use Yoruchiaki\WebaseFront\Exceptions\NoValidContractFunctionNameException;
use Yoruchiaki\WebaseFront\Tests\TestCase;
use Yoruchiaki\WebaseFront\ValueObjects\TransObject;

class TransServiceTest extends TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @test
     * @throws GuzzleException
     * @throws NoValidContractAddressException
     * @throws NoValidContractFunctionNameException
     */
    public function SignMessageHash()
    {
        $userName = $this->faker->uuid;
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->create($userName, $signUserId, 2, $this->appId, false);
        ['signUserId' => $signUserId] = $res;
        $this->assertAllResponseKey(['signUserId'], $res);
        $res = $this->abiClient->deployWithSign(
            $signUserId,
            $this->solidity
        );
        ['result' => $address] = $res;
        $this->assertAllResponseKey(['result'], $res);
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithSign(
            $signUserId,
            new TransObject(
                $address,
                $this->contractName,
                $this->contractAbi,
                'set',
                [$text]
            )
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
            $signUserId,
            $this->solidity
        );
        ['result' => $contractAddress] = $res;
        $this->assertAllResponseKey(['result'], $res);
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithLocal(
            $userAddress,
            new TransObject(
                $contractAddress,
                $this->contractName,
                $this->contractAbi,
                'set',
                [$text]
            )
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
            $signUserId,
            $this->solidity
        );
        ['result' => $contractAddress] = $res;
        $text = $this->faker->text(100);
        $res = $this->transClient->handleWithSign(
            $signUserId,
            new TransObject(
                $contractAddress,
                $this->contractName,
                $this->contractAbi,
                'set',
                [$text]
            )
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
            $signUserId,
            $this->solidity
        );
        ['result' => $contractAddress] = $res;
        $this->assertAllResponseKey(['result'], $res);
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithSign(
            $signUserId,
            new TransObject(
                $contractAddress,
                $this->contractName,
                $this->contractAbi,
                'set',
                [$text]
            )
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
            $signUserId,
            $this->solidity
        );
        ['result' => $contractAddress] = $res;
        $this->assertAllResponseKey(['result'], $res);
        $text = $this->faker->text(100);
        $res = $this->transClient->handle(
            $userAddress,
            new TransObject(
                $contractAddress,
                $this->contractName,
                $this->contractAbi,
                'set',
                [$text]
            )
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
            $signUserId,
            $this->solidity
        );
        ['result' => $contractAddress] = $res;
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithSign(
            $signUserId,
            new TransObject(
                $contractAddress,
                $this->contractName,
                $this->contractAbi,
                'set',
                [$text]
            )
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
            $signUserId,
            $this->solidity
        );
        ['result' => $contractAddress] = $res;
        $text = $this->faker->text(100);
        $res = $this->transClient->convertRawTxStrWithSign(
            $signUserId,
            new TransObject(
                $contractAddress,
                $this->contractName,
                $this->contractAbi,
                'set',
                [$text]
            )
        );
        $this->assertAllResponseKey(['result'], $res);
        ['result' => $signedStr] = $res;
        $res = $this->transClient->queryTransaction($signedStr, new TransObject(
            $contractAddress,
            $this->contractName,
            $this->contractAbi,
            'set',
            [$text]
        ));
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
        $res = $this->transClient->encodeFunction(new TransObject(
            '0x0',
            $this->contractName,
            $this->contractAbi,
            'set',
            [$text]
        ));
        $this->assertAllResponseKey(['result'], $res);
    }
}
