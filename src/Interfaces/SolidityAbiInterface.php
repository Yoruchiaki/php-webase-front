<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

interface SolidityAbiInterface
{
    public function __construct();

    public function toArray(): array;

    public function toString(): string;

    public function __toString(): string;

    public function checkFunctionName(string $functionName): bool;

    public function loadPath(string $path): self;

    public function valid(): bool;
}