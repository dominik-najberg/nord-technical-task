<?php declare(strict_types=1);

namespace App\Application\Geocoder;

use App\Infrastructure\Geocoder\Cache\DoctrineCacheGeocoderClient;
use App\Infrastructure\Geocoder\Dummy\DummyGeocoderClient;
use App\Infrastructure\Geocoder\Gmaps\GmapsGeocoderClient;
use App\Infrastructure\Geocoder\Hmaps\HereMapsGeocoderClient;

class GeocoderFactory
{
    private DoctrineCacheGeocoderClient $doctrineCacheGeocoderClient;
    private GmapsGeocoderClient $gmapsGeocoderClient;
    private HereMapsGeocoderClient $hereMapsGeocoderClient;
    private DummyGeocoderClient $dummyGeocoderClient;

    public function __construct(
        DoctrineCacheGeocoderClient $doctrineCacheGeocoder,
        GmapsGeocoderClient $gmapsGeocoder,
        HereMapsGeocoderClient $hereMapsGeocoder,
        DummyGeocoderClient $dummyGeocoderClient
    ){
        $this->doctrineCacheGeocoderClient = $doctrineCacheGeocoder;
        $this->gmapsGeocoderClient = $gmapsGeocoder;
        $this->hereMapsGeocoderClient = $hereMapsGeocoder;
        $this->dummyGeocoderClient = $dummyGeocoderClient;
    }

    public function createGmapsGeocoder(): Geocoder
    {
        return new Geocoder([
            $this->doctrineCacheGeocoderClient,
            $this->gmapsGeocoderClient,
        ]);
    }

    public function createHereMapsGeocoder(): Geocoder
    {
        return new Geocoder([
            $this->doctrineCacheGeocoderClient,
            $this->hereMapsGeocoderClient,
        ]);
    }

    public function createDummyMapsGeocoder(): Geocoder
    {
        return new Geocoder([
            $this->doctrineCacheGeocoderClient,
            $this->dummyGeocoderClient,
        ]);
    }
}
