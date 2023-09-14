<?php

namespace App\Application\Address;

class ResolvedAddress
{
    private int $id;
    private string $countryCode;
    private string $city;
    private string $street;
    private string $postcode;
    private ?string $lat;
    private ?string $lng;

    public function __construct(
        $countryCode,
        $city,
        $street,
        $postcode,
        $lat,
        $lng)
    {
        $this->countryCode = $countryCode;
        $this->city        = $city;
        $this->street      = $street;
        $this->postcode    = $postcode;
        $this->lat         = $lat;
        $this->lng         = $lng;
    }

    public function id()
    {
        return $this->id;
    }

    public function countryCode()
    {
        return $this->countryCode;
    }

    public function city()
    {
        return $this->city;
    }

    public function street()
    {
        return $this->street;
    }

    public function postcode()
    {
        return $this->postcode;
    }

    public function lat()
    {
        return $this->lat;
    }

    public function lng()
    {
        return $this->lng;
    }
}
