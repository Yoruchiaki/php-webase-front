<?php

namespace Yoruchiaki\WebaseFront\Tests;

use Faker\Factory;
use Faker\Generator;
use Yoruchiaki\WebaseFront\HttpClient\AppConfig;
use Yoruchiaki\WebaseFront\HttpClient\HttpRequest;
use Yoruchiaki\WebaseFront\Services\Abi\AbiService;
use Yoruchiaki\WebaseFront\Services\PrivateKey\PrivateKeyService;
use Yoruchiaki\WebaseFront\Services\Tool\ToolService;
use Yoruchiaki\WebaseFront\Services\Trans\TransService;
use Yoruchiaki\WebaseFront\ValueObjects\Solidity;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityBin;
use Yoruchiaki\WebaseFront\ValueObjects\SoliditySol;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected AbiService $abiClient;

    protected             $appId      = 'JvKV4BXK';
    protected SolidityAbi $contractAbi;
    protected SolidityBin $contractBin;
    protected string      $contractName;
    protected int         $groupId;
    protected SoliditySol $contractSol;
    protected Solidity    $solidity;
    protected string      $privateKey = '8cf98bd0f37fb0984ab43ed6fc2dcdf58811522af7e4a3bedbe84636a79a501c';
    protected Generator   $faker;
    /**
     * @var false|string
     */
    protected string $privatePem;

    protected PrivateKeyService $pkClient;
    protected TransService      $transClient;

    protected ToolService $toolClient;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $httpClient = new HttpRequest(
            new AppConfig(
                "http://10.0.200.118:5002/WeBASE-Front/",
                5
            )
        );
        $this->groupId = 1;
        $this->faker = Factory::create('zh-CN');
        $this->contractName = 'HelloWorld';
        $this->contractAbi = (new SolidityAbi())->loadPath(__DIR__.'/files/contracts/HelloWorld.abi');
        $this->contractBin = (new SolidityBin())->loadPath(__DIR__.'/files/contracts/HelloWorld.bin');
        $this->contractSol = (new SoliditySol())->loadPath(__DIR__.'/files/contracts/HelloWorld.sol');
        $this->solidity = new Solidity(
            $this->contractName,
            $this->contractAbi,
            $this->contractBin,
            $this->contractSol,
            []
        );
        $this->privatePem = file_get_contents(__DIR__.'/files/certs/test.pem');
        $this->abiClient = new AbiService($httpClient);
        $this->pkClient = new PrivateKeyService($httpClient);
        $this->transClient = new TransService($httpClient);
        $this->toolClient = new ToolService($httpClient);
    }

    protected function assertAllResponseKey(array $exist_key, array $response_array)
    {
        $this->assertIsArray($response_array);
        foreach ($exist_key as $key => $value) {
            $this->assertArrayHasKey(is_string($key) ? $key : $value, $response_array);
            if (is_string($key)) {
                $this->assertEquals($response_array[$key], $value);
            }
        }
    }
}