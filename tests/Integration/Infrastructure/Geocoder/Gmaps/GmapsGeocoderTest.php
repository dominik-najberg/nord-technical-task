<?php

namespace App\Tests\Integration\Infrastructure\Geocoder\Gmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Infrastructure\Geocoder\Gmaps\GmapsGeocoderClient;
use App\Infrastructure\Geocoder\Gmaps\GmapsRequestFactory;
use App\Infrastructure\Geocoder\Hmaps\HereMapsGeocoderClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GmapsGeocoderTest extends KernelTestCase
{
    public function test_it_connects_to_actual_service_provider(): void
    {
        self::bootKernel();
        $geocoderClient = self::$container->get(GmapsGeocoderClient::class);
        $expected = new Coordinates(52.284786, 20.9727795);

        $actual = $geocoderClient->geocode(new Address(
            'PL',
            'Warsaw',
            'Klaudyny 34',
            '01-684',
        ));

        self::assertEquals($expected, $actual);
    }
}
