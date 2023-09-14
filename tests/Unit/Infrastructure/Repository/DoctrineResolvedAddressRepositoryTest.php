<?php declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Repository;

use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Repository\ResolvedAddressRepository;
use App\Tests\Builder\ResolvedAddressBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineResolvedAddressRepositoryTest extends KernelTestCase
{
    private ResolvedAddressRepository $doctrineResolvedAddressRepository;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $this->doctrineResolvedAddressRepository = static::$container->get(ResolvedAddressRepository::class);
    }

    public function test_it_saves(): void
    {
        // Given
        $expected    = ResolvedAddressBuilder::new()->build();
        $address     = new Address(
            $expected->countryCode(),
            $expected->city(),
            $expected->street(),
            $expected->postcode(),
        );
        $coordinates = new Coordinates((float)$expected->lat(), (float)$expected->lng());

        // When
        $saved         = $this->doctrineResolvedAddressRepository->saveResolvedAddress($address, $coordinates);
        $entityManager = self::$container->get('doctrine')->getManager();
        $entityManager->clear();

        // Then
        $actual = $this->doctrineResolvedAddressRepository->find($saved->id());
        self::assertEquals($expected->countryCode(), $actual->countryCode());
        self::assertEquals($expected->city(), $actual->city());
        self::assertEquals($expected->street(), $actual->street());
        self::assertEquals($expected->postcode(), $actual->postcode());
        self::assertEquals($expected->lat(), $actual->lat());
        self::assertEquals($expected->lng(), $actual->lng());
    }

    public function test_it_gets_by_address(): void
    {
        // Given
        $expected    = ResolvedAddressBuilder::new()->build();
        $address     = new Address(
            $expected->countryCode(),
            $expected->city(),
            $expected->street(),
            $expected->postcode(),
        );
        $coordinates = new Coordinates((float)$expected->lat(), (float)$expected->lng());

        // When
        $this->doctrineResolvedAddressRepository->saveResolvedAddress($address, $coordinates);
        $entityManager = self::$container->get('doctrine')->getManager();
        $entityManager->clear();

        // Then
        $actual = $this->doctrineResolvedAddressRepository->findByAddress($address);
        self::assertEquals($expected->countryCode(), $actual->countryCode());
        self::assertEquals($expected->city(), $actual->city());
        self::assertEquals($expected->street(), $actual->street());
        self::assertEquals($expected->postcode(), $actual->postcode());
        self::assertEquals($expected->lat(), $actual->lat());
        self::assertEquals($expected->lng(), $actual->lng());
    }
}
