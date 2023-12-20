<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Exception\DictionaryException;
use Keiko\Uuid\Shortener\Shortener;
use PHPUnit\Framework\TestCase;

abstract class ShortenerTestCase extends TestCase
{
    abstract protected function shortener(Dictionary $dictionary = null): Shortener;

    /**
     * @dataProvider uuidShortenedUnmistakable
     */
    public function testUuidsAndShortUuidsAreIsomorphisms(string $uuid): void
    {
        self::assertSame(
            $uuid,
            $this->shortener()->expand($this->shortener()->reduce($uuid))
        );
    }

    /**
     * @dataProvider uuidShortenedUnmistakable
     */
    public function testTransformUuidToShorterEquivalentUsingUnmistakableCharsSet(string $uuid, string $reduced): void
    {
        $this->assertEquals($reduced, $this->shortener()->reduce($uuid));
    }

    /**
     * @dataProvider uuidShortenedAlphanumeric
     */
    public function testTransformUuidToShorterEquivalentUsingAlphanumericCharsSet($uuid, $reduced): void
    {
        $this->assertEquals($reduced, $this->shortener(Dictionary::createAlphanumeric())->reduce($uuid));
    }

    public function testShortUuidsWithInvalidDictionaryCharactersAreRejected(): void
    {
        $shortener = $this->shortener(new Dictionary('abcdefghijklmnopqrstuvwxz'));

        $this->expectException(DictionaryException::class);

        $shortener->expand('A');
    }

    public function testExpandShortUuid(): void
    {
        $this->assertEquals(
            '4e52c919-513e-4562-9248-7dd612c6c1ca',
            $this->shortener()->expand('fpfyRTmt6XeE9ehEKZ5LwF')
        );
    }

    public function uuidShortenedAlphanumeric(): array
    {
        return [
            ['4e52c919-513e-4562-9248-7dd612c6c1ca', 'wO7daP4yaaDlTYOcoXEnN3'],
            ['806d0969-95b3-433b-976f-774611fdacbb', 'rfMuQ8HQ7CY0sc9avYqKu4'],
            ['0c5873e8-7fea-4570-9487-ffe96ec30257', 'jnxYPDgoU155gsDuAWKIN'],
        ];
    }

    public function uuidShortenedUnmistakable(): array
    {
        return [
            ['4e52c919-513e-4562-9248-7dd612c6c1ca', 'fpfyRTmt6XeE9ehEKZ5LwF'],
            ['806d0969-95b3-433b-976f-774611fdacbb', 'mavTAjNm4NVztDwh4gdSrQ'],
            ['0c5873e8-7fea-4570-9487-ffe96ec30257', 'LpGtrrQFCbneY2GtQiXDD4'],
            ['ffffffff-ffff-ffff-ffff-ffffffffffff', '5B8cwPMGnU6qLbRvo7qEZo'],
            'One leading zero' => ['07fe2146-0a94-4a4a-9956-4cfd0d3560d9', 'rcPMmyWuaewoF8EM3JK5S3'],
            '2 Leading zeroes' => ['00fe2146-0a94-4a4a-9956-4cfd0d3560d9', 'qgXznd8uPVbCJg5tB5r5C'],
            'Smallest UUID, max leading zeroes' => ['00000000-0000-0000-0000-000000000001', '3'],
            'Small UUID, many leading zeroes' => ['00000000-0000-0000-0000-0000000000aa', 'z4'],
            'Large UUID, many trailing zeroes' => ['aa000000-0000-0000-0000-000000000000', 'ABitJoXBZDBeRvbiWuB5GY'],
            'Random UUID with trailing zeroes' => ['a7fe2146-0a94-4a4a-9956-4cfd0d3560d0', 'Fbab7rU5aCkhaybY3jphtX'],
        ];
    }
}
