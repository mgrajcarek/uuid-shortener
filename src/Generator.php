<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

final class Generator
{
    public function __construct(
        private readonly UuidFactory $uuidFactory,
        private readonly Shortener $shortener,
    ) {
    }

    public function generate(): string
    {
        return $this->shortener->reduce($this->uuidFactory->create());
    }
}
