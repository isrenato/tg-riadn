<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\EntityInterface;

interface ManagerInterface
{
    public function create(EntityInterface $entity): void;

    public function update(): void;
}
