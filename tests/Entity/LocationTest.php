<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Location;
use App\Entity\TelegramUser;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testSetAndGetId(): void
    {
        $location = new Location();
        $location->setId(1);

        $this->assertSame(1, $location->getId());
    }

    public function testSetAndGetAddress(): void
    {
        $location = new Location();
        $location->setAddress('123 Main St');

        $this->assertSame('123 Main St', $location->getAddress());
    }

    public function testSetAndGetTelegramUser(): void
    {
        $location = new Location();
        $telegramUser = $this->createMock(TelegramUser::class);

        $location->setTelegramUser($telegramUser);

        $this->assertSame($telegramUser, $location->getTelegramUser());
    }

    public function testSetAndIsProcessed(): void
    {
        $location = new Location();
        $location->setProcessed(true);

        $this->assertTrue($location->isProcessed());
    }
}
