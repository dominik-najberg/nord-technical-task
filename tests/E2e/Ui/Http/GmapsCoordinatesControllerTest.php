<?php

namespace App\Tests\E2e\Ui\Http;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// The same kind of test for the rest of the controllers
class GmapsCoordinatesControllerTest extends WebTestCase
{
    public function test_it_geocodes_google_maps(): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/gmaps', // Replace this with your actual route, if different
            [
                'country' => 'PL',
                'city' => 'Warsaw',
                'street' => 'Klaudyny 34',
                'postcode' => '01-684',
            ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseContent = $client->getResponse()->getContent();
        $responseArray = json_decode($responseContent, true);

        $this->assertEquals([
            'lat' => 52.284786,
            'lng' => 20.9727795
        ], $responseArray);
    }
}
