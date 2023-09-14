<?php

namespace App\Infrastructure\Repository;

use App\Application\Address\ResolvedAddress;
use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResolvedAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResolvedAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResolvedAddress[]    findAll()
 * @method ResolvedAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineResolvedAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResolvedAddress::class);
    }

    public function getByAddress(Address $address): ?ResolvedAddress
    {
        return $this->findOneBy([
            'countryCode' => $address->getCountry(),
            'city' => $address->getCity(),
            'street' => $address->getStreet(),
            'postcode' => $address->getPostcode()
        ]);
    }

    public function saveResolvedAddress(Address $address, ?Coordinates $coordinates): void
    {
        $resolvedAddress = new ResolvedAddress(
            $address->getCountry(),
            $address->getCity(),
            $address->getStreet(),
            $address->getPostcode(),
            (string) $coordinates->getLat(),
            (string) $coordinates->getLng(),
        );

        $this->getEntityManager()->persist($resolvedAddress);
        $this->getEntityManager()->flush();
    }
}
