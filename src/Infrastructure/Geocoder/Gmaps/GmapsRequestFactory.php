<?php declare(strict_types=1);

namespace App\Infrastructure\Geocoder\Gmaps;

use App\Application\Address\ValueObject\Address;
use GuzzleHttp\Psr7\Request;

class GmapsRequestFactory
{
    private bool $cacheHit = false;

    public static function create(Address $address, string $apiKey): Request
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

    public function isCacheHit(): bool
    {
        return $this->cacheHit;
    }
}
