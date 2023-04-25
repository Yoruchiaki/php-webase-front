<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;

use Illuminate\Support\Str;

class SolidityAbi
{
    private string $solidity_abi;

    public function __construct(string $solidity_abi_string)
    {
        $this->solidity_abi = trim($solidity_abi_string);
    }

    public function __toString(): string
    {
        return $this->solidity_abi;
    }

    public function toArray(): array
    {
        return json_decode($this->solidity_abi, true);
    }
}