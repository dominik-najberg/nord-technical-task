<?php declare(strict_types=1);

namespace App\Tests\Builder;

use App\Application\Address\ResolvedAddress;

class ResolvedAddressBuilder
{
    private string $countryCode;
    private string $city;
    private string $street;
    private string $postcode;
    private ?float $lat;
    private ?float $lng;

    private function __construct()
    {
        $this->countryCode = 'LV';
        $this->city        = 'Vilnius';
        $this->street      = 'Example Street';
        $this->postcode    = '12341';
        $this->lat         = 55.90742079144914;
        $this->lng         = 21.135541627577837;
    }

    public static function new(): self
    {
        return new self();
    }

    public function build(): ResolvedAddress
    {
        return new ResolvedAddress(
            $this->countryCode,
            $this->city,
            $this->street,
            $this->postcode,
            $this->lat,
            $this->lng,
        );
    }
}
