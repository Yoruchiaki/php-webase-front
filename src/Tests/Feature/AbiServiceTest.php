<?php

namespace Yoruchiaki\WebaseFront\Tests\Feature;

use GuzzleHttp\Exception\GuzzleException;
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
        $obj = $this->abiClient->contractList($this->groupId, 1, 10);
        $this->assertAllResponseKey(['code', 'message', 'data', 'totalCount'], $obj);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function deployWithSign()
    {
        $res = $this->abiClient->deployWithSign(
            $this->groupId,
            'bb086417c71147a0be1a9a7429079676',
            $this->contractAbi,
            $this->contractBin,
        );
        $this->assertIsArray($res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function compileJava()
    {
        $res = $this->abiClient->compileJava($this->contractName, json_decode($this->contractAbi, true), $this->contractBin,
            'com.test.package_name');
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
            $this->groupId,
            time()
        );
        $res = $this->abiClient->save(
            $this->groupId,
            $this->contractName,
            $contractPath,
            $this->contractSolidity,
            $this->contractAbi,
            $this->contractBin
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
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath($this->groupId, $this->faker->uuid());

        $save_res = $this->abiClient->save(
            $this->groupId,
            $this->contractName,
            $contractPath,
            $this->contractSolidity,
            $this->contractAbi,
            $this->contractBin
        );

        $delete_res = $this->abiClient->deleteContract($this->groupId, $save_res['id']);
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
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath($this->groupId, $this->faker->uuid());
        $save_res = $this->abiClient->save(
            $this->groupId,
            $this->contractName,
            $contractPath,
            $this->contractSolidity,
            $this->contractAbi,
            $this->contractBin
        );
        $res = $this->abiClient->ifChanged($this->groupId, $save_res['id']);
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
        $res = $this->abiClient->contractCompile($this->contractName, $this->contractSolidity);
        $this->assertIsArray($res);
        $this->assertAllResponseKey(['contractName', 'contractAbi', 'bytecodeBin', 'errors'], $res);
        $this->assertEquals($res['errors'], '');
    }

    public function contractListFull()
    {
        $res = $this->abiClient->contractListFull($this->groupId, 1);
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
        $res = $this->abiClient->contractListFull($this->groupId, 1);
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
        $res = $this->abiClient->addContractPath($this->groupId, $this->faker->uuid());
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
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath($this->groupId, $this->faker->uuid());
        $res = $this->abiClient->deleteContractPath($this->groupId, $contractPath);
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
        ['contractPath' => $contractPath] = $this->abiClient->addContractPath($this->groupId, $this->faker->uuid());
        $res = $this->abiClient->deleteContractByPath($this->groupId, $contractPath);
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
        ['result' => $contractAddress] = $this->abiClient->deployWithSign(
            $this->groupId,
            'debdea4753f7400db049f8268587abb4',
            $this->contractAbi,
            $this->contractBin,
        );
        $res = $this->abiClient->registerCns(
            $this->groupId,
            $this->contractName,
            $this->faker->uuid(),
            $contractAddress,
            $this->contractAbi,
            'v1.0.0',
            'debdea4753f7400db049f8268587abb4'
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
        ['result' => $contractAddress] = $this->abiClient->deployWithSign(
            $this->groupId,
            'debdea4753f7400db049f8268587abb4',
            $this->contractAbi,
            $this->contractBin,
        );
        $res = $this->abiClient->registerCns(
            $this->groupId,
            $this->contractName,
            $this->faker->uuid(),
            $contractAddress,
            $this->contractAbi,
            'v1.0.0',
            'debdea4753f7400db049f8268587abb4'
        );
        $res = $this->abiClient->findCns($this->groupId, $contractAddress);
        $this->assertAllResponseKey([
            'code'    => 0,
            'message' => 'success',
            'data'
        ], $res);
    }


}
