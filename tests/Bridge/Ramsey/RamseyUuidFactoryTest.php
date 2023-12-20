<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener\Bridge\Ramsey;

use Keiko\Uuid\Shortener\Bridge\Ramsey\RamseyUuidFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;

final class RamseyUuidFactoryTest extends TestCase
{
    /**
     * @dataProvider provideFactoryMethods
     */
    public function testCreateUuid(string $factoryMethod): void
    {
        $factory = new RamseyUuidFactory(
            new UuidFactory(),
            $factoryMethod,
        );

        $uuid1 = $factory->create();
        self::assertTrue(Uuid::isValid($uuid1));

        $uuid2 = $factory->create();
        self::assertTrue(Uuid::isValid($uuid2));

        self::assertNotSame($uuid1, $uuid2);
    }

    /**
     * @return iterable<array{string}>
     */
    public static function provideFactoryMethods(): iterable
    {
        $factoryMethods = (new \ReflectionClass(UuidFactoryInterface::class))->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($factoryMethods as $factoryMethod) {
            if (\str_starts_with($factoryMethod->name, 'uuid') && \preg_match('/[3,5]$/', $factoryMethod->name) === 0) {
                yield $factoryMethod->name => [$factoryMethod->name];
            }
        }
    }
}
