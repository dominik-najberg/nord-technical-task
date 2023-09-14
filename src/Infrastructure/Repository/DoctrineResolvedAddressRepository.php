<?php

namespace App\Infrastructure\Repository;

use App\Application\Address\ResolvedAddress;
use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;
use App\Application\Repository\ResolvedAddressRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResolvedAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResolvedAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResolvedAddress[]    findAll()
 * @method ResolvedAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineResolvedAddressRepository extends ServiceEntityRepository implements ResolvedAddressRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResolvedAddress::class);
    }

    public function getByAddress(Address $address): ResolvedAddress
    {
        $resolvedAddress = $this->findOneBy([
            'countryCode' => $address->getCountry(),
            'city' => $address->getCity(),
            'street' => $address->getStreet(),
            'postcode' => $address->getPostcode()
        ]);

        if (null === $resolvedAddress) {
            throw new EntityNotFoundException();
        }

        return $resolvedAddress;
    }

    public function saveResolvedAddress(Address $address, ?Coordinates $coordinates): ResolvedAddress
    {
        $resolvedAddress = new ResolvedAddress(
            $address->getCountry(),
            $address->getCity(),
            $address->getStreet(),
            $address->getPostcode(),
            $coordinates ? $coordinates->getLat() : null,
            $coordinates ? $coordinates->getLng() : null,
        );

        $this->getEntityManager()->persist($resolvedAddress);
        $this->getEntityManager()->flush();

        return $resolvedAddress;
    }
}
