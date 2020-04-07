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

    /**
     * @test
     */
    public function it_should_return_Dictionary_length()
    {
        // When
        $dictLength = $this->dictionary->getLength();

        // Then
        $this->assertEquals(57, $dictLength);
    }

    /**
     * @test
     */
    public function it_should_allow_to_get_selected_Dictionary_char()
    {
        // When
        $char = $this->dictionary->getCharAt(3);

        // Then
        $this->assertEquals('5', $char);
    }

    /**
     * @test
     */
    public function it_should_fail_when_out_of_bounds_dictionary_index_is_requested()
    {
        $this->expectExceptionObject(DictionaryException::indexOutOfBounds());

        // When
        $this->dictionary->getCharAt(100);
    }

    /**
     * @test
     * @dataProvider tooShortCharsSets
     *
     * @param string $charsSet
     */
    public function it_should_fail_when_constructing_chars_set_is_shorter_then_17_chars(string $charsSet)
    {
        $this->expectExceptionObject(DictionaryException::charsSetTooShort());

        // When
        new Dictionary($charsSet);
    }

    /**
     * @test
     */
    public function it_should_fail_when_constructing_chars_set_contains_non_unique_characters()
    {
        $this->expectExceptionObject(DictionaryException::nonUniqueChars());

        // When
        new Dictionary('1234567890ABCDEF123');
    }

    /**
     * @test
     */
    public function it_should_return_index_of_dictionary_element()
    {
        // When
        $index = $this->dictionary->getCharIndex('Z');

        // Then
        $this->assertEquals(31, $index);
    }

    /**
     * @test
     */
    public function it_should_fail_when_asked_for_a_char_not_existing_in_a_dictionary()
    {
        $this->expectExceptionObject(DictionaryException::charNotFound());

        // When
        $this->dictionary->getCharIndex('Ć');
    }

    /**
     * @test
     */
    public function let_it_be_constructed_with_unmistakable_chars_set()
    {
        // Given
        $dictionary = Dictionary::createUnmistakable();

        // When
        $length = $dictionary->getLength();
        $lastChar = $dictionary->getCharAt(56);

        // Then
        $this->assertEquals(57, $length);
        $this->assertEquals('z', $lastChar);
    }

    /**
     * @test
     */
    public function let_it_be_constructed_with_alphanumeric_chars_set()
    {
        // Given
        $dictionary = Dictionary::createAlphanumeric();

        // When
        $length = $dictionary->getLength();
        $lastChar = $dictionary->getCharAt(9);

        // Then
        $this->assertEquals(62, $length);
        $this->assertEquals('0', $lastChar);
    }

    /**
     * @return array
     */
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
