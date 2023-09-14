<?php declare(strict_types=1);

namespace App\Application\Geocoder;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;

class Geocoder
{
    /**
     * @var GeocoderClient[]
     */
    private array $geocoders;

    public function __construct(array $geocoders)
    {
        array_map(static fn (GeocoderClient $geocoder) => $geocoder, $geocoders);
        $this->geocoders = $geocoders;
    }

    public function geocode(Address $address): ?Coordinates
    {
        foreach ($this->geocoders as $geocoder) {
            $coordinates = $geocoder->geocode($address);
            if (null !== $coordinates) {
                return $coordinates;
            }
        }

        return null;
    }
}
