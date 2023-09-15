<?php

declare(strict_types=1);

namespace App\Infrastructure\Geocoder\Dummy;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Geocoder\GeocoderClient;

class DummyGeocoderClient implements GeocoderClient
{
    private bool $cacheHit = false;

    public function geocode(Address $address): ?Coordinates
    {
        return new Coordinates(55.90742079144914, 21.135541627577837);
    }

    public function isCacheHit(): bool
    {
        return $this->cacheHit;
    }
}
