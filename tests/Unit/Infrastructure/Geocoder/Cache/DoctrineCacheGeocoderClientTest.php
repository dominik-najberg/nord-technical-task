<?php

namespace App\Tests\Unit\Infrastructure\Geocoder\Cache;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Repository\ResolvedAddressRepository;
use App\Infrastructure\Geocoder\Cache\DoctrineCacheGeocoderClient;
use App\Tests\Builder\ResolvedAddressBuilder;
use PHPUnit\Framework\TestCase;

class DoctrineCacheGeocoderClientTest extends TestCase
{
    public function test_it_returns_correct_data(): void
    {
        // Given
        $resolvedAddress = ResolvedAddressBuilder::new()->build();
        $address = new Address(
            $resolvedAddress->countryCode(),
            $resolvedAddress->city(),
            $resolvedAddress->street(),
            $resolvedAddress->postcode()
        );
        $expected = new Coordinates($resolvedAddress->lat(), $resolvedAddress->lng());

        $resolvedAddressRepository = $this->createMock(ResolvedAddressRepository::class);
        $resolvedAddressRepository
            ->expects(self::once())
            ->method('findByAddress')
            ->with($address)
            ->willReturn($resolvedAddress);

        $geocoderClient = new DoctrineCacheGeocoderClient($resolvedAddressRepository);

        // When
        $actual = $geocoderClient->geocode($address);

        // Then
        self::assertEquals($expected, $actual);
    }

    public function test_it_returns_null_on_not_found(): void
    {
        // Given
        $address = new Address(
            'PL',
            'Xyz',
            'Da Street',
            '12345'
        );

        $resolvedAddressRepository = $this->createMock(ResolvedAddressRepository::class);
        $resolvedAddressRepository
            ->expects(self::once())
            ->method('findByAddress')
            ->with($address)
            ->willReturn(null);

        $geocoderClient = new DoctrineCacheGeocoderClient($resolvedAddressRepository);

        // When
        $actual = $geocoderClient->geocode($address);

        // Then
        self::assertNull($actual);
    }
}
