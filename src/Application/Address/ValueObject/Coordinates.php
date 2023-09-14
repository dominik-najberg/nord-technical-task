<?php

declare(strict_types=1);

namespace App\Application\Address\ValueObject;

class Coordinates
{
    private float $lat;
    private float $lng;

    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function lat(): float
    {
        return $this->lat;
    }

    public function lng(): float
    {
        return $this->lng;
    }
}
