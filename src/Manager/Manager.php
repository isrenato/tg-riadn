<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\EntityInterface;
use App\Manager\ManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Manager implements ManagerInterface
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {
    }

    public function create(EntityInterface $entity): void
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }

    public function update(): void
    {
        $this->manager->flush();
    }
}
