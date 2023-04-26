<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;

use Yoruchiaki\WebaseFront\Exceptions\SolidityAbiConstructException;

class SolidityAbi
{
    private array $solidity_abi;

    /**
     * @throws SolidityAbiConstructException
     */
    public function __construct(string $solidity_abi_string)
    {
        $this->solidity_abi = json_decode(trim($solidity_abi_string), true);
        $error = json_last_error();
        if ($error !== 0) {
            throw new SolidityAbiConstructException();
        }
    }

    public function __toString(): string
    {
        return json_encode($this->solidity_abi);
    }

    public function toArray(): array
    {
        return $this->solidity_abi;
    }

    public function toString(): string
    {
        return (string) $this;
    }


    /**
     * 检查入参函数名称在Abi中是否存在,如果不存在则抛出异常
     *
     * @param  string  $functionName
     *
     * @return bool
     */
    public function check(string $functionName): bool
    {
        $exist = false;
        foreach ($this->solidity_abi as $item) {
            if ($item['type'] !== 'function') {
                continue;
            }
            if (isset($item['name']) && $item['name'] === $functionName) {
                $exist = true;
                break;
            }
        }
        return $exist;
    }
}