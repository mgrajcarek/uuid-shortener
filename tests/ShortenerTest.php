<?php

namespace Test\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Shortener;
use PHPUnit\Framework\TestCase;

class ShortenerTest extends TestCase
{

    /**
     * @var Shortener
     */
    private $shortener;

    public function setup()
    {
        $this->shortener = new Shortener(
            Dictionary::DICTIONARY_UNMISTAKABLE,
            new Converter()
        );
    }

    /**
     * @test
     */
    public function it_should_transform_uuid_to_a_shorter_equivalent_using_short_set_of_characters()
    {
        // Given
        $uuid = '4e52c919-513e-4562-9248-7dd612c6c1ca';

        // When
        $shortened = $this->shortener->reduce($uuid);

        // Then
        $this->assertEquals('fpfyRTmt6XeE9ehEKZ5LwF', $shortened);
    }

}