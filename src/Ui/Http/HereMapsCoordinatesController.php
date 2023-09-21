<?php

declare(strict_types=1);

namespace App\Ui\Http;

use App\Application\Address\ValueObject\Address;
use App\Application\Geocoder\Geocoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HereMapsCoordinatesController extends AbstractController
{
    private Geocoder $geocoder;

    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    public function __invoke(Request $request): Response
    {
        $country = $request->get('country', 'LT');
        $city = $request->get('city', 'vilnius');
        $street = $request->get('street', 'jasinskio 16');
        $postcode = $request->get('postcode', '01112');

        $coordinates = $this->geocoder->geocode(
            new Address($country, $city, $street, $postcode)
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
