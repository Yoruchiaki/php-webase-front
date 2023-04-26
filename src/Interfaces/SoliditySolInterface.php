<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

interface SoliditySolInterface
{
    public function __construct(string $solidity_sol_string = null);

    public function __toString(): string;

    public function toString(): string;

    public function valid(): bool;
}