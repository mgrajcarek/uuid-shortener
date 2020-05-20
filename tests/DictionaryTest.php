<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Exception\DictionaryException;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    /**
     * @var Dictionary
     */
    private $dictionary;

    protected function setUp(): void
    {
        $this->dictionary = new Dictionary('23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
    }

    public function testInitialDictionaryState(): void
    {
        self::assertSame(
            '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz',
            $this->dictionary->charsSet
        );
        self::assertSame(57, $this->dictionary->length);
        self::assertSame(
            [
                2   => 0,
                3   => 1,
                4   => 2,
                5   => 3,
                6   => 4,
                7   => 5,
                8   => 6,
                9   => 7,
                'A' => 8,
                'B' => 9,
                'C' => 10,
                'D' => 11,
                'E' => 12,
                'F' => 13,
                'G' => 14,
                'H' => 15,
                'J' => 16,
                'K' => 17,
                'L' => 18,
                'M' => 19,
                'N' => 20,
                'P' => 21,
                'Q' => 22,
                'R' => 23,
                'S' => 24,
                'T' => 25,
                'U' => 26,
                'V' => 27,
                'W' => 28,
                'X' => 29,
                'Y' => 30,
                'Z' => 31,
                'a' => 32,
                'b' => 33,
                'c' => 34,
                'd' => 35,
                'e' => 36,
                'f' => 37,
                'g' => 38,
                'h' => 39,
                'i' => 40,
                'j' => 41,
                'k' => 42,
                'm' => 43,
                'n' => 44,
                'o' => 45,
                'p' => 46,
                'q' => 47,
                'r' => 48,
                's' => 49,
                't' => 50,
                'u' => 51,
                'v' => 52,
                'w' => 53,
                'x' => 54,
                'y' => 55,
                'z' => 56,
            ],
            $this->dictionary->charIndexes
        );
    }

    public function testReturnDictionaryLength(): void
    {
        $this->assertEquals(57, $this->dictionary->getLength());
    }

    public function testReturnDictionaryCharAt(): void
    {
        $this->assertEquals('5', $this->dictionary->getCharAt(3));
    }

    public function testThrowExceptionWhenDictionaryCharAtIsOutOfBounds(): void
    {
        $this->expectExceptionObject(DictionaryException::indexOutOfBounds());

        $this->dictionary->getCharAt(100);
    }

    /**
     * @dataProvider tooShortCharsSets
     */
    public function testThrowExceptionWhenProvidedCharsSetIsTooShort(string $charsSet): void
    {
        $this->expectExceptionObject(DictionaryException::charsSetTooShort());

        new Dictionary($charsSet);
    }

    public function testThrowsExceptionWhenProvidedCharsSetContainsNonUniqueCharacters(): void
    {
        $this->expectExceptionObject(DictionaryException::nonUniqueChars());

        new Dictionary('1234567890ABCDEF123');
    }

    public function testReturnCharIndex(): void
    {
        $this->assertEquals(31, $this->dictionary->getCharIndex('Z'));
    }

    public function testThrowExceptonWhenGettingNonExistentCharsIndex(): void
    {
        $this->expectExceptionObject(DictionaryException::charNotFound());

        $this->dictionary->getCharIndex('Ć');
    }
    public function testCreateUnmistakableDictionary(): void
    {
        $dictionary = Dictionary::createUnmistakable();

        $this->assertEquals(57, $dictionary->getLength());
        $this->assertEquals('z', $dictionary->getCharAt(56));
    }

    public function testCreateAlphanumericDictionary(): void
    {
        $dictionary = Dictionary::createAlphanumeric();

        $this->assertEquals(62, $dictionary->getLength());
        $this->assertEquals('0', $dictionary->getCharAt(9));
    }

    public function tooShortCharsSets(): array
    {
        return [
            [''],
            ['abc'],
            ['1234567890'],
            ['1234567890ABCDEF'],
        ];
    }
}
