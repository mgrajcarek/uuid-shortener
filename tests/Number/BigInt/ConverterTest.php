<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener\Number\BigInt;

use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Moontoast\Math\BigNumber;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /**
     * @var Converter
     */
    private $converter;

    protected function setUp()
    {
        $this->converter = new Converter();
    }

    /**
     * @test
     */
    public function it_should_transform_BigNumbers_into_hexadecimal_values()
    {
        // Given
        $number = new BigNumber(254, 0);

        // When
        $hex = $this->converter->toHex($number);

        // Then
        $this->assertEquals('fe', $hex);
    }

    /**
     * @test
     */
    public function it_should_transform_hexadecimal_values_into_BigNumbers()
    {
        // Given
        $hex = 'fd';

        // When
        $bigNumber = $this->converter->fromHex($hex);

        // Then
        $this->assertInstanceOf(BigNumber::class, $bigNumber);
        $this->assertEquals(253, $bigNumber->getValue());
    }
}
