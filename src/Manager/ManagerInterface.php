<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface ManagerInterface
{
    public function create(EntityInterface $entity): void;

    public function update(): void;

    public function delete(EntityInterface $entity): void;

    public function createMultiply(ArrayCollection $entities): void;
}
