<?php declare(strict_types=1);

namespace App\Ui\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GeocodeRequest
{
    public string $country;

    public string $city;

    public string $street;

    public string $postcode;

    private function __construct(string $country, string $city, string $street, string $postcode)
    {
        $this->country  = $country;
        $this->city     = $city;
        $this->street   = $street;
        $this->postcode = $postcode;
    }

    public static function fromRequest(Request $request): self
    {
        $country = $request->get('country', 'LT');
        $city = $request->get('city', 'vilnius');
        $street = $request->get('street', 'jasinskio 16');
        $postcode = $request->get('postcode', '01112');

        // add validation in code for better control
        // or add Symfony's Validator

        return new self($country, $city, $street, $postcode);
    }
}
