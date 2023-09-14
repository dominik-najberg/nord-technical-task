<?php declare(strict_types=1);

namespace App\Infrastructure\Geocoder\Hmaps;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Geocoder\GeocoderInterface;
use App\Infrastructure\Geocoder\Gmaps\GmapsRequestFactory;
use Psr\Http\Client\ClientInterface;

class HereMapsGeocoder implements GeocoderInterface
{
    private string $apiKey;
    private ClientInterface $client;

    public function __construct(string $apiKey, ClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    public function geocode(Address $address): ?Coordinates
    {
        $request = HereMapsRequestFactory::make($address, $this->apiKey);
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $firstResult = $data['items'][0] ?? null;

        if (null === $firstResult) {
            return null;
        }

        return new Coordinates(
            (string) $firstResult['position']['lat'],
            (string) $firstResult['position']['lng'],
        );
    }
}
