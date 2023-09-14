<?php

declare(strict_types=1);

namespace App\Application\Address\ValueObject;

class Address
{
    private string $country;
    private string $city;
    private string $street;
    private string $postcode;

    public function __construct(string $country, string $city, string $street, string $postcode)
    {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->postcode = $postcode;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function street(): string
    {
        return $this->street;
    }

    public function postcode(): string
    {
        return $this->postcode;
    }
}
