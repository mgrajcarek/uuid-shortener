<?php
declare(strict_types = 1);

namespace Test\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    /**
     * @var Dictionary
     */
    private $dictionary;

    public function setup()
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
        $char = $this->dictionary->getElement(3);

        // Then
        $this->assertEquals('5', $char);
    }

    /**
     * @test
     * @expectedException \Keiko\Uuid\Shortener\Exception\DictionaryException
     * @expectedExceptionMessage Index not available in the Dictionary
     */
    public function it_should_fail_when_out_of_bounds_dictionary_index_is_requested()
    {
        // When
        $this->dictionary->getElement(100);
    }

    /**
     * @test
     * @expectedException \Keiko\Uuid\Shortener\Exception\DictionaryException
     * @expectedExceptionMessage Dictionary charset is too short to reduce UUID
     * @dataProvider tooShortCharset
     *
     * @param string $charset
     */
    public function it_should_fail_when_constructing_charset_is_shorter_then_17_chars(string $charset)
    {
        // When
        new Dictionary($charset);
    }

    /**
     * @test
     * @expectedException \Keiko\Uuid\Shortener\Exception\DictionaryException
     * @expectedExceptionMessage Dictionary contains non unique characters
     */
    public function it_should_fail_when_constructing_charset_contains_non_unique_characters()
    {
        // When
        new Dictionary('1234567890ABCDEF123');
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
        $lastChart = $dictionary->getElement(56);

        // Then
        $this->assertEquals(57, $length);
        $this->assertEquals('z', $lastChart);
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
        $lastChart = $dictionary->getElement(9);

        // Then
        $this->assertEquals(62, $length);
        $this->assertEquals('0', $lastChart);
    }

    /**
     * @return array
     */
    public function tooShortCharset(): array
    {
        return [
            [''],
            ['abc'],
            ['1234567890'],
            ['1234567890ABCDEF']
        ];
    }
}