<?php

namespace Yoruchiaki\WebaseFront\Tests\Feature;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Yoruchiaki\WebaseFront\Tests\TestCase;

class AbiServiceTest extends TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function contractList()
    {
        $obj = $this->abiClient->contractList(1, 10);
        $this->assertAllResponseKey(['code', 'message', 'data', 'totalCount'], $obj);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function deployWithSign()
    {
        ['signUserId' => $signUserId] = $this->pkClient->create(
            'admin',
            str_replace('-', '', $this->faker->uuid()),
            2,
            $this->appId,
            true
        );
        $res = $this->abiClient->deployWithSign(
            $signUserId,
            $this->solidity
        );
        $this->assertAllResponseKey(['result'], $res);
        $this->assertNotEquals('0x0000000000000000000000000000000000000000', $res['result']);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function compileJava()
    {
        $res = $this->abiClient->compileJava($this->solidity, 'com.test.package_name');
        $this->assertAllResponseKey(['result'], $res);
        $this->assertStringContainsString("com.test.package_name", $res['result']);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function save()
    {
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath(
            time()
        );
        $res = $this->abiClient->save(
            $this->solidity,
            $contractPath
        );
        $this->assertAllResponseKey([
            'id',
            'contractPath',
            'contractName',
            'contractStatus',
            'groupId',
            'contractSource',
            'contractAbi',
            'contractBin',
            'bytecodeBin',
            'contractAddress',
            'deployTime',
            'description',
            'createTime',
            'modifyTime',
        ], $res);
    }


    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function deleteContract()
    {
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath($this->faker->uuid());

        $save_res = $this->abiClient->save(
            $this->solidity,
            $contractPath,
        );

        $delete_res = $this->abiClient->deleteContract($save_res['id']);
        $this->assertIsArray($delete_res);
        $this->assertAllResponseKey(['code', 'message', 'data'], $delete_res);
        $this->assertEquals($delete_res['code'], 0);
        $this->assertEquals($delete_res['data'], null);
        $this->assertEquals($delete_res['message'], 'success');
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function ifChanged()
    {
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath($this->faker->uuid());
        $save_res = $this->abiClient->save(
            $this->solidity,
            $contractPath,
        );
        $res = $this->abiClient->ifChanged($save_res['id']);
        $this->assertIsArray($res);
        $this->assertAllResponseKey(['result'], $res);
    }


    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function contractCompile()
    {
        $res = $this->abiClient->contractCompile($this->contractName, $this->contractSol);
        $this->assertIsArray($res);
        $this->assertAllResponseKey(['contractName', 'contractAbi', 'bytecodeBin', 'errors'], $res);
        $this->assertEquals($res['errors'], '');
    }

    public function contractListFull()
    {
        $res = $this->abiClient->contractListFull(1);
        $this->assertIsArray($res);
        $this->assertAllResponseKey(['code' => 0, 'message', 'data', 'totalCount'], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function findOne()
    {
        $res = $this->abiClient->contractListFull(1);
        $res = $this->abiClient->findOne($res['data'][0]['id']);
        $this->assertAllResponseKey([
            'code'    => 0,
            'message' => 'success',
            'data'
        ], $res);
    }


    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function findContractPathList()
    {
        $res = $this->abiClient->findContractPathList($this->groupId);
        $this->assertAllResponseKey([], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function addContractPath()
    {
        $res = $this->abiClient->addContractPath($this->faker->uuid());
        $this->assertAllResponseKey([
            'groupId' => 1,
            'contractPath',
            'createTime',
            'modifyTime'
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function deleteContractPath()
    {
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath($this->faker->uuid());
        $res = $this->abiClient->deleteContractPath($contractPath);
        $this->assertAllResponseKey([
            'code'    => 0,
            'message' => 'success'
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function deleteContractByPath()
    {
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath($this->faker->uuid());
        $res = $this->abiClient->deleteContractByPath($contractPath);
        $this->assertAllResponseKey([
            'code'    => 0,
            'message' => 'success'
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function registerCns()
    {
        ['signUserId' => $signUserId] = $this->pkClient->create(
            $this->faker->userName,
            str_replace('-', '', $this->faker->uuid()),
            2,
            $this->appId,
            false
        );
        ['result' => $contractAddress] = $this->abiClient->deployWithSign(
            $signUserId,
            $this->solidity
        );
        $res = $this->abiClient->registerCns(
            $this->solidity,
            $contractAddress,
            $this->faker->uuid(),
            'v1.0.0',
            $signUserId
        );
        $this->assertAllResponseKey([
            "code"    => 0,
            "message" => "success"
        ], $res);
    }

    /**
     * @test
     * @return void
     */
    public function findCns()
    {
        ['signUserId' => $signUserId] = $this->pkClient->create(
            $this->faker->userName,
            str_replace('-', '', $this->faker->uuid()),
            2,
            $this->appId,
            false
        );
        ['result' => $contractAddress] = $this->abiClient->deployWithSign(
            $signUserId,
            $this->solidity
        );
        $this->abiClient->registerCns(
            $this->solidity,
            $contractAddress,
            $this->faker->uuid(),
            'v1.0.0',
            $signUserId
        );
        $res = $this->abiClient->findCns($contractAddress);
        $this->assertAllResponseKey([
            'code'    => 0,
            'message' => 'success',
            'data'
        ], $res);
    }
}
