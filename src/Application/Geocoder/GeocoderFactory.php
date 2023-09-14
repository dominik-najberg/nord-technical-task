<?php declare(strict_types=1);

namespace App\Application\Geocoder;

use App\Infrastructure\Geocoder\Cache\DoctrineCacheGeocoderClient;
use App\Infrastructure\Geocoder\Gmaps\GmapsGeocoderClient;
use App\Infrastructure\Geocoder\Hmaps\HereMapsGeocoderClient;

class GeocoderFactory
{
    private DoctrineCacheGeocoderClient $doctrineCacheGeocoderClient;
    private GmapsGeocoderClient $gmapsGeocoderClient;
    private HereMapsGeocoderClient $hereMapsGeocoderClient;

    public function __construct(
        DoctrineCacheGeocoderClient $doctrineCacheGeocoder,
        GmapsGeocoderClient $gmapsGeocoder,
        HereMapsGeocoderClient $hereMapsGeocoder
    ){
        $this->doctrineCacheGeocoderClient = $doctrineCacheGeocoder;
        $this->gmapsGeocoderClient         = $gmapsGeocoder;
        $this->hereMapsGeocoderClient      = $hereMapsGeocoder;
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
}
