<?php

namespace Yoruchiaki\WebaseFront\Interfaces;

interface SolidityBinInterface
{
    public function __construct(string $file_content = null);

    public function toString(): string;

    public function __toString(): string;

    public function loadPath(string $path): self;

    public function valid(): bool;
}