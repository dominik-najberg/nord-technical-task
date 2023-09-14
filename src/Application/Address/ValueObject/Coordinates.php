<?php

declare(strict_types=1);

namespace App\Application\Address\ValueObject;

class Coordinates
{
    private string $lat;
    private string $lng;

    public function __construct(string $lat, string $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function lat(): string
    {
        return $this->lat;
    }

    public function lng(): string
    {
        return $this->lng;
    }
}
