<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;

use Yoruchiaki\WebaseFront\Exceptions\SolidityAbiConstructException;
use Yoruchiaki\WebaseFront\Interfaces\SolidityAbiInterface;

class SolidityAbi implements SolidityAbiInterface
{
    private array $solidity_abi;

    /**
     * @throws SolidityAbiConstructException
     */
    public function __construct(string $file_content = null)
    {
        if ($file_content) {
            $this->solidity_abi = json_decode(trim($file_content), true);
            $error = json_last_error();
            if ($error !== 0) {
                throw new SolidityAbiConstructException();
            }
        }
    }

    public function __toString(): string
    {
        if (!$this->valid()) {
            throw new \Exception('Abi类初始化失败!');
        }
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
    public function checkFunctionName(string $functionName): bool
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

    /**
     * @param  string  $path
     *
     * @return $this
     * @throws SolidityAbiConstructException
     */
    public function loadPath(string $path): SolidityAbi
    {
        $fileContext = file_get_contents($path);
        $this->solidity_abi = json_decode($fileContext, true);
        return $this;
    }

    /**
     * 验证对象本身是否有效
     *
     * @return bool
     */
    public function valid(): bool
    {
        return !!$this->solidity_abi;
    }
}