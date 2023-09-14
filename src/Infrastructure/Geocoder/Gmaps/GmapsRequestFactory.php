<?php declare(strict_types=1);

namespace App\Infrastructure\Geocoder\Gmaps;

use App\Application\Address\ValueObject\Address;
use GuzzleHttp\Psr7\Request;

class GmapsRequestFactory
{
    public static function make(Address $address, string $apiKey): Request
    {
        $params = http_build_query([
            'address' => $address->street(),
            'components' => implode('|', [
                "country:{$address->country()}",
                "locality:{$address->city()}",
                "postal_code:{$address->postcode()}",
            ]),
            'key' => $apiKey,
        ]);

        $uri = 'https://maps.googleapis.com/maps/api/geocode/json?' . $params;

        return new Request('GET', $uri);
    }
}
