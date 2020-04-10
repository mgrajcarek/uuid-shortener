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
