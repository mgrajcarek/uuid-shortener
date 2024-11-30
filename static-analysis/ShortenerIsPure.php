<?php

declare(strict_types=1);

namespace Test\Keiko\StaticAnalysis;

use Brick\Math\BigInteger;
use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Number\BigInt\ConverterInterface;
use Keiko\Uuid\Shortener\Shortener;

/**
 * This is a static analysis fixture to verify that the API signature
 * of the shortener allows for pure operations. Almost all methods will
 * seem to be redundant or trivial: that's normal, we're just verifying
 * the transitivity of immutable type signatures.
 *
 * Please note that this does not guarantee that the internals of the library are
 * pure/safe, but just that the declared API to the outside world is seen as
 * immutable.
 *
 * @psalm-immutable
 */
final class ShortenerIsPure
{
    public function testImmutableConverterFromHex(
        ConverterInterface $converter,
        string $hex,
    ): BigInteger {
        return $converter->fromHex($hex);
    }

    public function testImmutableConverterToHex(
        ConverterInterface $converter,
        BigInteger $number,
    ): string {
        return $converter->toHex($number);
    }

    public function testDictionaryCreateUnmistakable(): Dictionary
    {
        return Dictionary::createUnmistakable();
    }

    public function testDictionaryCreateAlphanumeric(): Dictionary
    {
        return Dictionary::createAlphanumeric();
    }

    public function testDictionaryLength(): int
    {
        return (new Dictionary('abc'))
            ->getLength();
    }

    public function testDictionaryCharAt(): string
    {
        return (new Dictionary('abc'))
            ->getCharAt(1);
    }

    public function testDictionaryGetCharIndex(): int
    {
        return (new Dictionary('abc'))
            ->getCharIndex('b');
    }

    public function testShortenerReduce(): string
    {
        return (new Shortener(Dictionary::createAlphanumeric(), new Converter()))
            ->reduce('806d0969-95b3-433b-976f-774611fdacbb');
    }

    public function testShortenerExpand(): string
    {
        return (new Shortener(Dictionary::createAlphanumeric(), new Converter()))
            ->reduce('LpGtrrQFCbneY2GtQiXDD4');
    }
}
