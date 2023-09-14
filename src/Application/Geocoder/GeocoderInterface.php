<?php

declare(strict_types=1);

namespace App\Application\Geocoder;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;

interface GeocoderInterface
{
    public function geocode(Address $address): ?Coordinates;
}
