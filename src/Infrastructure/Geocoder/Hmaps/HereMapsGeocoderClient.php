<?php declare(strict_types=1);

namespace App\Infrastructure\Geocoder\Hmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Geocoder\GeocoderClient;
use App\Infrastructure\Geocoder\Gmaps\GmapsRequestFactory;
use Psr\Http\Client\ClientInterface;

class HereMapsGeocoderClient implements GeocoderClient
{
    private string $apiKey;
    private ClientInterface $client;
    private bool $cacheHit = false;

    public function __construct(string $apiKey, ClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    public function geocode(Address $address): ?Coordinates
    {
        $request = HereMapsRequestFactory::create($address, $this->apiKey);
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $firstResult = $data['items'][0] ?? null;

        if (null === $firstResult) {
            return null;
        }

        return new Coordinates(
            (float) $firstResult['position']['lat'],
            (float) $firstResult['position']['lng'],
        );
    }

    public function isCacheHit(): bool
    {
        return $this->cacheHit;
    }
}
