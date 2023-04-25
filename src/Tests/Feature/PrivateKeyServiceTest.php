<?php

namespace Yoruchiaki\WebaseFront\Tests\Feature;

use GuzzleHttp\Exception\GuzzleException;
use Yoruchiaki\WebaseFront\Tests\TestCase;

class PrivateKeyServiceTest extends TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function import()
    {
        $userName = $this->faker->userName;
        $res = $this->pkClient->import($this->privateKey, $userName);
        $this->assertAllResponseKey([
            'address',
            'publicKey',
            'privateKey',
            'userName' => $userName,
            'type'
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function localKeyStores()
    {
        $res = $this->pkClient->localKeyStores();
        $this->assertAllResponseKey([], $res);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function deleteByAddress()
    {
        $userName = $this->faker->userName;
        ['address' => $address] = $this->pkClient->import($this->privateKey, $userName);
        $res = $this->pkClient->deleteByAddress($address);
        $this->assertAllResponseKey([
            'code'    => 0,
            'message' => 'success',
            'data'    => null
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function importPem()
    {
        $userName = $this->faker->userName;
        $res = $this->pkClient->importPem($this->privatePem, $userName);
        $this->assertAllResponseKey([
            'code'    => 0,
            'message' => 'success',
            'data'    => null
        ], $res);
    }

    /**
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function importWithSign()
    {
        $signUserId = str_replace('-', '', $this->faker->uuid());
        $res = $this->pkClient->importWithSign($signUserId, $this->appId, base64_encode($this->privateKey));
        $this->assertAllResponseKey([
            'appId'      => $this->appId,
            'publicKey'  => '041c7073dc185af0644464b178da932846666a858bc492450e9e94c77203428ed54e2ce45679dbb36bfed714dbe055a215dc1aaf4a75faeddce6a62b39c0158e1e',
            'signUserId' => $signUserId
        ], $res);
    }
}
