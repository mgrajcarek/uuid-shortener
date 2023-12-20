<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener\Bridge\Symfony;

use Keiko\Uuid\Shortener\UuidFactory;
use Symfony\Component\Uid\Factory\UuidFactory as SfUuidFactory;

final class SymfonyUuidFactory implements UuidFactory
{
    public function __construct(
        private readonly SfUuidFactory $uuidFactory,
    ) {
    }

    public function create(): string
    {
        return (string) $this->uuidFactory->create();
    }
}
