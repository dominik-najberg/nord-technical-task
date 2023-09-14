<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Geocoder\GeocoderInterface;

class DummyGeocoder implements GeocoderInterface
{
    public function geocode(Address $address): ?Coordinates
    {
        return new Coordinates(55.90742079144914, 21.135541627577837);
    }
}
