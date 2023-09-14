<?php

namespace App\Tests\Unit\Infrastructure\Geocoder\Hmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Infrastructure\Geocoder\Gmaps\GmapsGeocoderClient;
use App\Infrastructure\Geocoder\Hmaps\HereMapsGeocoderClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

class HereMapsGeocoderTest extends TestCase
{
    public function test_it_decodes(): void
    {
        // Given
        $clientMock = $this->createMock(ClientInterface::class);
        $clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->willReturn(
                new Response(
                    200,
                    [],
                    $this->getHereMapsResponse(),
                )
            );

        $geoCoder = new HereMapsGeocoderClient('123', $clientMock);
        $expected = new Coordinates('52.28281', '20.97424');

        // When
        $actual = $geoCoder->geocode(new Address('PL', 'Warsaw', 'Klaudyny', '01-684'));

        // Then
        self::assertEquals($expected, $actual);
    }

    private function getHereMapsResponse(): string
    {
        return '{
                  "items": [
                    {
                      "title": "ulica Klaudyny, 01-684 Bielany, Polska",
                      "id": "here:af:streetsection:mVlU7g-EB5en7YI9TvOT5D",
                      "resultType": "street",
                      "address": {
                        "label": "ulica Klaudyny, 01-684 Bielany, Polska",
                        "countryCode": "POL",
                        "countryName": "Polska",
                        "state": "Woj. Mazowieckie",
                        "county": "Warszawa",
                        "city": "Warszawa",
                        "district": "Bielany",
                        "subdistrict": "Marymont-Kaskada",
                        "street": "ulica Klaudyny",
                        "postalCode": "01-684"
                      },
                      "position": {
                        "lat": 52.28281,
                        "lng": 20.97424
                      },
                      "mapView": {
                        "west": 20.97056,
                        "south": 52.27947,
                        "east": 20.97786,
                        "north": 52.2861
                      },
                      "scoring": {
                        "queryScore": 0.44,
                        "fieldScore": {
                          "country": 1.0,
                          "city": 1.0,
                          "streets": [
                            0.9
                          ],
                          "postalCode": 1.0
                        }
                      }
                    }
                  ]
                }
        ';
    }
}
