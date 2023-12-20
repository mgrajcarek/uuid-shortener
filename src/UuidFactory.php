<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

interface UuidFactory
{
    public function create(): string;
}
