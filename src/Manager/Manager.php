<?php

declare(strict_types=1);

namespace App\StorageInteractionManager;

use App\Entity\EntityInterface;
use App\Manager\ManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class Manager implements ManagerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $manager
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

    public function delete($entity): void
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }
}
