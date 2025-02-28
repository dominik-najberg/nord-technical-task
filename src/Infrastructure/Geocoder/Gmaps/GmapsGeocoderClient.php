<?php declare(strict_types=1);

namespace App\Infrastructure\Geocoder\Gmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Geocoder\GeocoderClient;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

class GmapsGeocoderClient implements GeocoderClient
{
    private bool $cacheHit = false;
    private string $apiKey;
    private ClientInterface $client;

    public function __construct(string $apiKey, ClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    public function geocode(Address $address): ?Coordinates
    {
        $request = GmapsRequestFactory::create($address, $this->apiKey);
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $firstResult = $data['results'][0] ?? null;
        if (null === $firstResult) {
            return null;
        }

        if ($firstResult['geometry']['location_type'] !== 'ROOFTOP') {
            return null;
        }

        return new Coordinates(
            (float) $firstResult['geometry']['location']['lat'],
            (float) $firstResult['geometry']['location']['lng'],
        );
    }

    public function isCacheHit(): bool
    {
        return $this->cacheHit;
    }
}
