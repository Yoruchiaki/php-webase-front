<?php

namespace Yoruchiaki\WebaseFront\ValueObjects;

use Illuminate\Support\Str;

class SoliditySource
{
    private string $solidity;

    public function __construct(string $solidity_source_string)
    {
        $this->solidity = base64_encode(trim($solidity_source_string));
    }

    public function __toString(): string
    {
        return $this->solidity;
    }
}