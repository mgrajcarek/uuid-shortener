<?php

declare(strict_types=1);

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

    protected function setUp()
    {
        $this->shortener = new Shortener(
            Dictionary::createUnmistakable(),
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
            ['0c5873e8-7fea-4570-9487-ffe96ec30257', 'LpGtrrQFCbneY2GtQiXDD4'],
            'One leading zero'                  => ['07fe2146-0a94-4a4a-9956-4cfd0d3560d9', 'rcPMmyWuaewoF8EM3JK5S3'],
            '2 Leading zeroes'                  => ['00fe2146-0a94-4a4a-9956-4cfd0d3560d9', 'qgXznd8uPVbCJg5tB5r5C'],
            'Smallest UUID, max leading zeroes' => ['00000000-0000-0000-0000-000000000001', '3'],
            'Small UUID, many leading zeroes'   => ['00000000-0000-0000-0000-0000000000aa', 'z4'],
            'Large UUID, many trailing zeroes'  => ['aa000000-0000-0000-0000-000000000000', 'ABitJoXBZDBeRvbiWuB5GY'],
            'Random UUID with trailing zeroes'  => ['a7fe2146-0a94-4a4a-9956-4cfd0d3560d0', 'Fbab7rU5aCkhaybY3jphtX'],
        ];
    }

    /**
     * @test
     * @dataProvider uuidShortenedUnmistakable
     */
    public function uuids_and_short_uuids_are_isomorphisms(string $uuid)
    {
        self::assertSame(
            $uuid,
            $this->shortener->expand($this->shortener->reduce($uuid))
        );
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
            ['0c5873e8-7fea-4570-9487-ffe96ec30257', 'jnxYPDgoU155gsDuAWKIN'],
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
            Dictionary::createAlphanumeric(),
            new Converter()
        );

        // When
        $shortened = $this->shortener->reduce($uuid);

        // Then
        $this->assertEquals($reduced, $shortened);
    }

    /**
     * @test
     */
    public function it_should_transform_short_uuid_into_its_hexadecimal_equivalent()
    {
        // When
        $expanded = $this->shortener->expand('fpfyRTmt6XeE9ehEKZ5LwF');

        // Then
        $this->assertEquals('4e52c919-513e-4562-9248-7dd612c6c1ca', $expanded);
    }
}
