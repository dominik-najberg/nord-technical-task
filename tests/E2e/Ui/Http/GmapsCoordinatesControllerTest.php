<?php

namespace App\Tests\E2e\Ui\Http;

use App\Application\Address\ResolvedAddress;
use App\Application\Address\ValueObject\Address;
use App\Application\Repository\ResolvedAddressRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GmapsCoordinatesControllerTest extends WebTestCase
{
    public const COUNTRY = 'PL';
    public const CITY = 'Warsaw';
    public const STREET = 'Klaudyny 34';
    public const POSTCODE = '01-684';

    public function test_it_geocodes_google_maps(): void
    {
        $client = static::createClient();
        /** @var ResolvedAddressRepository $repository */
        $repository = $client->getContainer()->get('doctrine')->getManager()->getRepository(ResolvedAddress::class);
        $expected = new ResolvedAddress(
            self::COUNTRY,
            self::CITY,
            self::STREET,
            self::POSTCODE,
            52.284786,
            20.9727795
        );

        $client->request(
            'GET',
            '/gmaps',
            [
                'country' => self::COUNTRY,
                'city' => self::CITY,
                'street' => self::STREET,
                'postcode' => self::POSTCODE,
            ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseContent = $client->getResponse()->getContent();
        $responseArray = json_decode($responseContent, true);

        $this->assertEquals([
            'lat' => 52.284786,
            'lng' => 20.9727795
        ], $responseArray);

        $actual = $repository->findByAddress(
            new Address(self::COUNTRY, self::CITY, self::STREET, self::POSTCODE)
        );

        self::assertInstanceOf(ResolvedAddress::class, $actual);
        self::assertEquals($expected->countryCode(), $actual->countryCode());
        self::assertEquals($expected->city(), $actual->city());
        self::assertEquals($expected->street(), $actual->street());
        self::assertEquals($expected->postcode(), $actual->postcode());
        self::assertEquals($expected->lat(), $actual->lat());
        self::assertEquals($expected->lng(), $actual->lng());
    }
}
