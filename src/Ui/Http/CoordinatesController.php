<?php

declare(strict_types=1);

namespace App\Ui\Http;

use App\Application\Address\ValueObject\Address;
use App\Application\Geocoder\Geocoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoordinatesController
{
    private Geocoder $geocoder;

    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    public function __invoke(Request $request): Response
    {
        $geocodeRequest = GeocodeRequest::fromRequest($request);

        $coordinates = $this->geocoder->geocode(
            new Address(
                $geocodeRequest->country,
                $geocodeRequest->city,
                $geocodeRequest->street,
                $geocodeRequest->postcode
            )
        );

        if (null === $coordinates) {
            return new JsonResponse([]);
        }

        return new JsonResponse([
                'lat' => $coordinates->lat(),
                'lng' => $coordinates->lng(),
            ]
        );
    }
}
