<?php declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Address\ResolvedAddress;
use App\Application\Address\ValueObject\Address;
use App\Application\Address\ValueObject\Coordinates;

interface ResolvedAddressRepository
{
    public function findByAddress(Address $address): ?ResolvedAddress;
    public function saveResolvedAddress(Address $address, ?Coordinates $coordinates): ResolvedAddress;
}
