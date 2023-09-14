<?php

declare(strict_types=1);

namespace App\Ui\Http;

use App\Application\Address\ValueObject\Address;
use App\Application\Geocoder\Geocoder;
use App\Application\Geocoder\GeocoderClient;
use App\Application\Geocoder\GeocoderFactory;
use App\Infrastructure\Repository\DoctrineResolvedAddressRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GmapsCoordinatesController extends AbstractController
{
    private Geocoder $geocoder;

    public function __construct(GeocoderFactory $geocoder)
    {
        $this->geocoder = $geocoder->createGmapsGeocoder();
    }

    public function __invoke(Request $request): Response
    {
        $country = $request->get('country', 'lithuania');
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
