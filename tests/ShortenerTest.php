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
     * @return array
     */
    public function uuidShortenedUnmistakable()
    {
        return [
            ['4e52c919-513e-4562-9248-7dd612c6c1ca', 'fpfyRTmt6XeE9ehEKZ5LwF'],
            ['806d0969-95b3-433b-976f-774611fdacbb', 'mavTAjNm4NVztDwh4gdSrQ'],
            ['0c5873e8-7fea-4570-9487-ffe96ec30257', 'LpGtrrQFCbneY2GtQiXDD4']
        ];
    }

    /**
     * @test
     * @dataProvider uuidShortenedUnmistakable
     *
     * @param string $uuid
     * @param string $reduced
     */
    public function it_should_transform_uuid_to_a_shorter_equivalent_using_short_set_of_characters($uuid, $reduced)
    {
        // When
        $shortened = $this->shortener->reduce($uuid);

        // Then
        $this->assertEquals($reduced, $shortened);
    }

    /**
     * @return array
     */
    public function uuidShortenedAlphanumeric()
    {
        return [
            ['4e52c919-513e-4562-9248-7dd612c6c1ca', 'wO7daP4yaaDlTYOcoXEnN3'],
            ['806d0969-95b3-433b-976f-774611fdacbb', 'rfMuQ8HQ7CY0sc9avYqKu4'],
            ['0c5873e8-7fea-4570-9487-ffe96ec30257', 'jnxYPDgoU155gsDuAWKIN']
        ];
    }

    /**
     * @test
     * @dataProvider uuidShortenedAlphanumeric
     *
     * @param string $uuid
     * @param string $reduced
     */
    public function it_should_transform_uuid_to_a_shorter_equivalent_using_normal_set_of_characters($uuid, $reduced)
    {
        // Given
        $this->shortener = new Shortener(
            Dictionary::DICTIONARY_ALPHANUMERIC,
            new Converter()
        );

        // When
        $shortened = $this->shortener->reduce($uuid);

        // Then
        $this->assertEquals($reduced, $shortened);
    }

}