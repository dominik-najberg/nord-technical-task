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

        if (count($data['results']) === 0) {
            return null;
        }

        $firstResult = $data['results'][0];

        if ($firstResult['geometry']['location_type'] !== 'ROOFTOP') {
            return null;
        }

        return new Coordinates(
            (float) $firstResult['geometry']['location']['lat'],
            (float) $firstResult['geometry']['location']['lng'],
        );
    }
}
