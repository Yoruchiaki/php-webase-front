<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;


class SolidityBin
{
    private string $solidity_bin;

    public function __construct(string $solidity_abi_string)
    {
        $this->solidity_bin = trim($solidity_abi_string);
    }

    public function __toString(): string
    {
        return $this->solidity_bin;
    }

    public function toString(): string
    {
        return $this->solidity_bin;
    }
}