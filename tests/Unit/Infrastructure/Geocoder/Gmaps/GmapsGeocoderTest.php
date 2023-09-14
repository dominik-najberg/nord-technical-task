<?php

namespace App\Tests\Unit\Infrastructure\Geocoder\Gmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Infrastructure\Geocoder\Gmaps\GmapsGeocoderClient;
use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GmapsGeocoderTest extends TestCase
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
                    $this->getGmapsResponse(),
                )
            );

        $geoCoder = new GmapsGeocoderClient('123', $clientMock);
        $expected = new Coordinates(37.4224764, -122.0842499);

        // When
        $actual = $geoCoder->geocode(new Address('US', 'Santa Clara', '1600 Amphitheatre Pkwy', '94043'));

        // Then
        self::assertEquals($expected, $actual);
    }

    private function getGmapsResponse(): string
    {
        return '{
                  "results": [
                    {
                      "address_components": [
                        {
                          "long_name": "1600",
                          "short_name": "1600",
                          "types": ["street_number"]
                        },
                        {
                          "long_name": "Amphitheatre Pkwy",
                          "short_name": "Amphitheatre Pkwy",
                          "types": ["route"]
                        },
                        {
                          "long_name": "Mountain View",
                          "short_name": "Mountain View",
                          "types": ["locality", "political"]
                        },
                        {
                          "long_name": "Santa Clara County",
                          "short_name": "Santa Clara County",
                          "types": ["administrative_area_level_2", "political"]
                        },
                        {
                          "long_name": "California",
                          "short_name": "CA",
                          "types": ["administrative_area_level_1", "political"]
                        },
                        {
                          "long_name": "United States",
                          "short_name": "US",
                          "types": ["country", "political"]
                        },
                        {
                          "long_name": "94043",
                          "short_name": "94043",
                          "types": ["postal_code"]
                        }
                      ],
                      "formatted_address": "1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA",
                      "geometry": {
                        "location": {
                          "lat": 37.4224764,
                          "lng": -122.0842499
                        },
                        "location_type": "ROOFTOP",
                        "viewport": {
                          "northeast": {
                            "lat": 37.4238253802915,
                            "lng": -122.0829009197085
                          },
                          "southwest": {
                            "lat": 37.4211274197085,
                            "lng": -122.0855988802915
                          }
                        }
                      },
                      "place_id": "ChIJ2eUgeAK6j4ARbn5u_wAGqWA",
                      "plus_code": {
                        "compound_code": "CWC8+V9 Mountain View, California, United States",
                        "global_code": "849VCWC8+V9"
                      },
                      "types": ["street_address"]
                    }
                  ],
                  "status": "OK"
                }
        ';
    }
}
