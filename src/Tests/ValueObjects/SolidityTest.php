<?php

namespace ValueObjects;

use Yoruchiaki\WebaseFront\Tests\TestCase;

class SolidityTest extends TestCase
{

    public function testGetSolidityAbi()
    {
        $this->assertEquals($this->solidity->getSolidityAbi()->toArray(), $this->contractAbi->toArray());
    }

    public function test__construct()
    {
        $this->assertIsObject($this->solidity);
    }

    public function testGetContractName()
    {
        $name = $this->solidity->getContractName();
        $this->assertEquals($name, $this->contractName);
    }

    public function testGetSolidityBin()
    {
        $this->assertEquals($this->solidity->getSolidityBin()->toString(), $this->contractBin->toString());
    }

    public function testGetConstructParams()
    {
        $this->assertEquals([], $this->solidity->getConstructParams());
    }

    public function testGetSoliditySource()
    {
        $this->assertEquals($this->contractSol->toString(), $this->solidity->getSoliditySol()->toString());
    }
}
