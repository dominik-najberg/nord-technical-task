<?php declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Repository;

use App\Infrastructure\Repository\DoctrineResolvedAddressRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineResolvedAddressRepositoryTest extends KernelTestCase
{
    private DoctrineResolvedAddressRepository $doctrineResolvedAddressRepository;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $this->doctrineResolvedAddressRepository = static::$container->get(DoctrineResolvedAddressRepository::class);
    }

    public function test_it_saves(): void
    {

    }
}
