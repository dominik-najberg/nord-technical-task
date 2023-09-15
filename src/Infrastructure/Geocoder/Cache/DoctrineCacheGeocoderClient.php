<?php declare(strict_types=1);

namespace App\Infrastructure\Geocoder\Cache;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Geocoder\GeocoderClient;
use App\Application\Repository\ResolvedAddressRepository;

class DoctrineCacheGeocoderClient implements GeocoderClient
{
    private ResolvedAddressRepository $resolvedAddressRepository;

    public function __construct(ResolvedAddressRepository $resolvedAddressRepository)
    {
        $this->resolvedAddressRepository = $resolvedAddressRepository;
    }

    public function geocode(Address $address): ?Coordinates
    {
        $resolvedAddress = $this->resolvedAddressRepository->findByAddress($address);

        if (null !== $resolvedAddress) {
            return new Coordinates(
                (float) $resolvedAddress->lat(),
                (float) $resolvedAddress->lng()
            );
        }

        return null;
    }
}
