<?php

namespace Feature;

use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Tests\TestCase;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;

class ToolServiceTest extends TestCase
{

    /**
     * @return void
     * @throws GuzzleException
     */
    public function SignMsg()
    {
        ['privateKey' => $privateKey] = $this->toolClient->keypair();
        $res = $this->toolClient->signMsg(
            '7de55cd04600d4059f10d2d5908e94b89a3ad577151ba539a28cb8ccb1fe3b73',
            "0xcfadfa0000000000000000000000000000000000000000000000000000000000"
        );
        var_dump($res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function Decode()
    {
        $res = $this->toolClient->decode(1, 'newEvidence',
            '0xa12bb1d8000000000000000000000000000000000000000000000000000000000000002000000000000000000000000000000000000000000000000000000000000000097465737431323131320000000000000000000000000000000000000000000000',
            new SolidityAbi('[{"constant":true,"inputs":[{"name":"index","type":"uint256"}],"name":"getSigner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getSigners","outputs":[{"name":"","type":"address[]"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getSignersSize","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"addr","type":"address"}],"name":"verify","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"evi","type":"string"}],"name":"newEvidence","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"}],"name":"addSignatures","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"addr","type":"address"}],"name":"getEvidence","outputs":[{"name":"","type":"string"},{"name":"","type":"address[]"},{"name":"","type":"address[]"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[{"name":"evidenceSigners","type":"address[]"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"addr","type":"address"}],"name":"newEvidenceEvent","type":"event"}]'),
            '0x000000000000000000000000e9d0a146298b2454a26f43adb81f800ccf98b947');
        $this->assertAllResponseKey(['result' => "test12112"], $res);

        $res = $this->toolClient->decode(2, 'newEvidence',
            '0xa12bb1d8000000000000000000000000000000000000000000000000000000000000002000000000000000000000000000000000000000000000000000000000000000097465737431323131320000000000000000000000000000000000000000000000',
            new SolidityAbi('[{"constant":true,"inputs":[{"name":"index","type":"uint256"}],"name":"getSigner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getSigners","outputs":[{"name":"","type":"address[]"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getSignersSize","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"addr","type":"address"}],"name":"verify","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"evi","type":"string"}],"name":"newEvidence","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"}],"name":"addSignatures","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"addr","type":"address"}],"name":"getEvidence","outputs":[{"name":"","type":"string"},{"name":"","type":"address[]"},{"name":"","type":"address[]"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[{"name":"evidenceSigners","type":"address[]"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"addr","type":"address"}],"name":"newEvidenceEvent","type":"event"}]'),
            '0x000000000000000000000000e9d0a146298b2454a26f43adb81f800ccf98b947');
        $this->assertAllResponseKey(['[0xe9d0a146298b2454a26f43adb81f800ccf98b947]'], $res);

    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function Hash()
    {
        $res = $this->toolClient->hash(123, 1);
        $this->assertAllResponseKey([
            'hashValue'   => "64e604787cbf194841e7b68d7cd28786f6c9a0a3ab9f8b0a0e87cb4387ab0107",
            'encryptType' => 0
        ], $res);

        $res = $this->toolClient->hash(123, 2);
        $this->assertAllResponseKey([
            'hashValue'   => "64e604787cbf194841e7b68d7cd28786f6c9a0a3ab9f8b0a0e87cb4387ab0107",
            'encryptType' => 0
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function Utf8ToHexString()
    {
        $res = $this->toolClient->utf8ToHexString(123);
        $this->assertAllResponseKey(['result' => '313233'], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function Keypair()
    {
        $res = $this->toolClient->keypair('a81dfd0d3b1004d6635e099aeddd0e939481081372d791b0c477bb21c663105d');
        $this->assertAllResponseKey([
            'privateKey'  => 'a81dfd0d3b1004d6635e099aeddd0e939481081372d791b0c477bb21c663105d',
            'publicKey'   => "04aa95cfddb68f6e583a204e479536ac2d6f8fba254ef08cfad82aa48b1d9eadd58314d7cbd3c0a8461b68219577ee511e84c630a0df252afa35bd86aa12f1ebff",
            'address'     => '0x988f01939de8797789ea4889e39a7039af9f4c11',
            'encryptType' => 0,
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function Address()
    {
        $res = $this->toolClient->address('0xaa95cfddb68f6e583a204e479536ac2d6f8fba254ef08cfad82aa48b1d9eadd58314d7cbd3c0a8461b68219577ee511e84c630a0df252afa35bd86aa12f1ebff');
        $this->assertAllResponseKey([
            'publicKey'   => '0xaa95cfddb68f6e583a204e479536ac2d6f8fba254ef08cfad82aa48b1d9eadd58314d7cbd3c0a8461b68219577ee511e84c630a0df252afa35bd86aa12f1ebff',
            'address'     => '0x988f01939de8797789ea4889e39a7039af9f4c11',
            'encryptType' => 0
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function Convert2Bytes32()
    {
        $res = $this->toolClient->convert2Bytes32("123", 1);
        $this->assertAllResponseKey(['result' => '0x0123000000000000000000000000000000000000000000000000000000000000'],
            $res);
        $res = $this->toolClient->convert2Bytes32("123", 2);
        $this->assertAllResponseKey(['result' => '0x3132330000000000000000000000000000000000000000000000000000000000'],
            $res);
    }
}
