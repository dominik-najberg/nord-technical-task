<?php declare(strict_types=1);

namespace App\Application\Geocoder;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Repository\ResolvedAddressRepository;

class Geocoder
{
    /** @var GeocoderClient[] */
    private array $geocoders;
    private ResolvedAddressRepository $resolvedAddressRepository;

    public function __construct(array $geocoders, ResolvedAddressRepository $resolvedAddressRepository)
    {
        array_map(static fn (GeocoderClient $geocoder) => $geocoder, $geocoders);
        $this->geocoders = $geocoders;
        $this->resolvedAddressRepository = $resolvedAddressRepository;
    }

    public function geocode(Address $address): ?Coordinates
    {
        foreach ($this->geocoders as $geocoder) {
            $coordinates = $geocoder->geocode($address);
            if (null !== $coordinates) {
                $this->resolvedAddressRepository->saveResolvedAddress($address, $coordinates);

                return $coordinates;
            }
        }

        return null;
    }
}
