<?php

namespace App\Tests\Integration\Infrastructure\Geocoder\Gmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Infrastructure\Geocoder\Gmaps\GmapsGeocoder;
use App\Infrastructure\Geocoder\Gmaps\GmapsRequestFactory;
use App\Infrastructure\Geocoder\Hmaps\HereMapsGeocoder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GmapsGeocoderTest extends KernelTestCase
{
    public function test_it_decodes(): void
    {
        self::bootKernel();
        $geocoder = self::$container->get(GmapsGeocoder::class);
        $expected = new Coordinates('52.284786','20.9727795');

        $actual = $geocoder->geocode(new Address(
            'PL',
            'Warsaw',
            'Klaudyny 34',
            '01-684',
        ));

        self::assertEquals($expected, $actual);
    }
}
