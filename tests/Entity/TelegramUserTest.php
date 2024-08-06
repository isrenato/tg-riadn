<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Location;
use App\Entity\TelegramUser;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class TelegramUserTest extends TestCase
{
    public function testSetAndGetId(): void
    {
        $telegramUser = new TelegramUser();
        $telegramUser->setId(1);

        $this->assertSame(1, $telegramUser->getId());
    }

    public function testSetAndGetUsername(): void
    {
        $telegramUser = new TelegramUser();
        $telegramUser->setUsername('testuser');

        $this->assertSame('testuser', $telegramUser->getUsername());
    }

    public function testSetAndGetTelegramId(): void
    {
        $telegramUser = new TelegramUser();
        $telegramUser->setTelegramId(123456);

        $this->assertSame(123456, $telegramUser->getTelegramId());
    }

    public function testAddAndRemoveLocation(): void
    {
        $telegramUser = new TelegramUser();
        $location = new Location();

        $this->assertCount(0, $telegramUser->getLocations());

        $telegramUser->addLocation($location);
        $this->assertCount(1, $telegramUser->getLocations());
        $this->assertSame($telegramUser, $location->getTelegramUser());

        $telegramUser->removeLocation($location);
        $this->assertCount(0, $telegramUser->getLocations());
        $this->assertNull($location->getTelegramUser());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $telegramUser = new TelegramUser();
        $now = new DateTimeImmutable();
        $telegramUser->setCreatedAt($now);

        $this->assertSame($now, $telegramUser->getCreatedAt());
    }

    public function testSetAndGetUpdatedAt(): void
    {
        $telegramUser = new TelegramUser();
        $now = new DateTimeImmutable();
        $telegramUser->setUpdatedAt($now);

        $this->assertSame($now, $telegramUser->getUpdatedAt());
    }

    public function testSetCreatedAtValue(): void
    {
        $telegramUser = new TelegramUser();
        $telegramUser->setCreatedAtValue();

        $this->assertInstanceOf(DateTimeImmutable::class, $telegramUser->getCreatedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $telegramUser->getUpdatedAt());
    }

    public function testSetUpdatedAtValue(): void
    {
        $telegramUser = new TelegramUser();
        $telegramUser->setUpdatedAtValue();

        $this->assertInstanceOf(DateTimeImmutable::class, $telegramUser->getUpdatedAt());
    }
}
