<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener\Bridge\Symfony;

use Keiko\Uuid\Shortener\Bridge\Symfony\SymfonyUuidFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV1;
use Symfony\Component\Uid\UuidV3;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Uid\UuidV5;
use Symfony\Component\Uid\UuidV6;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Uid\UuidV8;

final class SymfonyUuidFactoryTest extends TestCase
{
    /**
     * @dataProvider provideFactoryMethods
     */
    public function testCreateUuid(string $uuidClass): void
    {
        $factory = new SymfonyUuidFactory(new UuidFactory($uuidClass));

        $uuid1 = $factory->create();
        self::assertTrue(Uuid::isValid($uuid1));

        $uuid2 = $factory->create();
        self::assertTrue(Uuid::isValid($uuid2));

        self::assertNotSame($uuid1, $uuid2);
    }

    /**
     * @return iterable<array{class-string<Uuid>}>
     */
    public static function provideFactoryMethods(): iterable
    {
        yield 'v1' => [UuidV1::class];
        // yield 'v3' => [UuidV3::class];
        yield 'v4' => [UuidV4::class];
        // yield 'v5' => [UuidV5::class];
        yield 'v6' => [UuidV6::class];
        yield 'v7' => [UuidV7::class];
        // yield 'v8' => [UuidV8::class];
    }
}
