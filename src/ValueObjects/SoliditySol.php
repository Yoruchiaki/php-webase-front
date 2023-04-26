<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;


use Yoruchiaki\WebaseFront\Interfaces\SoliditySolInterface;

/**
 *
 */
class SoliditySol implements SoliditySolInterface
{
    /**
     * @var string
     */
    private string $solidity_sol;

    /**
     * @param  string|null  $solidity_source_string
     */
    public function __construct(string $solidity_source_string = null)
    {
        if ($solidity_source_string !== null) {
            $this->solidity_sol = base64_encode(trim($solidity_source_string));
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->solidity_sol;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return base64_encode($this->solidity_sol);
    }

    /**
     * @param  string  $path
     *
     * @return $this
     */
    public function loadPath(string $path): SoliditySol
    {
        $this->solidity_sol = file_get_contents($path);
        return $this;
    }

    /**
     * 验证对象本身是否有效
     *
     * @return bool
     */
    public function valid(): bool
    {
        return !!$this->solidity_sol;
    }
}