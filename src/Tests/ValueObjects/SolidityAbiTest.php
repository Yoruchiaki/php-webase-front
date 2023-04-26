<?php

namespace ValueObjects;

use Yoruchiaki\WebaseFront\Exceptions\SolidityAbiConstructException;
use Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi;
use PHPUnit\Framework\TestCase;

class SolidityAbiTest extends TestCase
{

    private SolidityAbi $abi;

    /**
     * @throws SolidityAbiConstructException
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->abi = new SolidityAbi(file_get_contents(__DIR__.'/../files/contracts/HelloWorld.abi'));
    }

    public function testToArray()
    {
        $arr = $this->abi->toArray();
        $this->assertIsArray($arr);
        $this->assertCount(3, $arr);
    }

    public function test__toString()
    {
        $this->assertEquals('[{"constant":false,"inputs":[{"name":"n","type":"string"}],"name":"set","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"get","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"}]',
            file_get_contents(__DIR__.'/../files/contracts/HelloWorld.abi'));
    }

    /**
     * @throws SolidityAbiConstructException
     */
    public function test__construct()
    {
        $abi = new SolidityAbi(file_get_contents(__DIR__.'/../files/contracts/HelloWorld.abi'));
        $this->assertIsObject($abi);
        $this->assertObjectHasAttribute('solidity_abi', $abi);
    }

    public function testCheck()
    {
        $check_result = $this->abi->check('set');
        $this->assertEquals(true, $check_result);
    }
}
