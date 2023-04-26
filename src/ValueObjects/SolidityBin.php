<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;


use Yoruchiaki\WebaseFront\Interfaces\SolidityBinInterface;

class SolidityBin implements SolidityBinInterface
{
    private string $solidity_bin;

    public function __construct(string $file_content = null)
    {
        if ($file_content) {
            $this->solidity_bin = $file_content;
        }
    }

    public function __toString(): string
    {
        return $this->solidity_bin;
    }

    public function toString(): string
    {
        return $this->solidity_bin;
    }

    /**
     * @param  string  $path
     *
     * @return $this
     */
    /**
     * @param  string  $path
     *
     * @return $this
     */
    public function loadPath(string $path): SolidityBin
    {
        $this->solidity_bin = file_get_contents($path);
        return $this;
    }

    /**
     * 验证对象本身是否有效
     *
     * @return bool
     */
    public function valid(): bool
    {
        return !!$this->solidity_bin;
    }
}