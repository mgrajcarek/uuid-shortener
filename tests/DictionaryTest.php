<?php

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
        $this->dictionary = new Dictionary('abcdZ');
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
     * @test
     */
    public function it_should_return_Dictionary_length()
    {
        // When
        $dictLength = $this->dictionary->getLength();

        // Then
        $this->assertEquals(5, $dictLength);
    }

    /**
     * @test
     */
    public function it_should_allow_to_get_selected_Dictionary_char()
    {
        // When
        $char = $this->dictionary->getElement(3);

        // Then
        $this->assertEquals('d', $char);
    }



}