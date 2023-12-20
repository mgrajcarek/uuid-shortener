<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener\Bridge\Ramsey;

use Keiko\Uuid\Shortener\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;

final class RamseyUuidFactory implements UuidFactory
{
    public function __construct(
        private readonly UuidFactoryInterface $uuidFactory,
        private readonly string $method,
    ) {
    }

    public function create(): string
    {
        return $this->uuidFactory->{$this->method}()->toString();
    }
}
