<?php

namespace App\Tests\Integration\Infrastructure\Geocoder\Hmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Infrastructure\Geocoder\Hmaps\HereMapsGeocoderClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HereMapsGeocoderTest extends KernelTestCase
{
    public function test_it_connects_to_actual_service_provider(): void
    {
        self::bootKernel();
        $geocoderClient = self::$container->get(HereMapsGeocoderClient::class);
        $expected = new Coordinates(52.28483, 20.97277);

        $actual = $geocoderClient->geocode(new Address(
            'PL',
            'Warsaw',
            'Klaudyny 34',
            '01-684',
        ));

        self::assertEquals($expected, $actual);
    }
}
