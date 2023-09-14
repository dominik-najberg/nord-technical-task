<?php

namespace App\Tests\Integration\Infrastructure\Geocoder\Hmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Infrastructure\Geocoder\Hmaps\HereMapsGeocoder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HereMapsGeocoderTest extends KernelTestCase
{
    public function test_it_decodes(): void
    {
        self::bootKernel();
        $geocoder = self::$container->get(HereMapsGeocoder::class);
        $expected = new Coordinates('52.28483','20.97277');

        $actual = $geocoder->geocode(new Address(
            'PL',
            'Warsaw',
            'Klaudyny 34',
            '01-684',
        ));

        self::assertEquals($expected, $actual);
    }
}
