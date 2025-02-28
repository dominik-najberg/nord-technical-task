<?php declare(strict_types=1);

namespace App\Infrastructure\Geocoder\Hmaps;

use App\Application\Address\ValueObject\Address;
use GuzzleHttp\Psr7\Request;

class HereMapsRequestFactory
{
    public static function create(Address $address, string $apiKey): Request
    {
        $params = http_build_query([
            'q' => implode(';', [
                "address={$address->country()}",
                "city={$address->city()}",
                "street={$address->street()}",
                "postalCode={$address->postcode()}"
            ]),
            'apiKey' => $apiKey
        ]);

        $uri = 'https://geocode.search.hereapi.com/v1/geocode?' . $params;

        return new Request('GET', $uri);
    }
}
