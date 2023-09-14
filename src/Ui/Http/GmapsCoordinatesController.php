<?php

declare(strict_types=1);

namespace App\Ui\Http;

use App\Application\Address\ValueObject\Address;
use App\Application\Geocoder\GeocoderInterface;
use App\Infrastructure\Repository\DoctrineResolvedAddressRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GmapsCoordinatesController extends AbstractController
{
    private GeocoderInterface $geocoder;

    public function __construct(GeocoderInterface $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * @Route(path="/gmaps", name="gmaps")
     * @param Request $request
     * @return Response
     */
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
