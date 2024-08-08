<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Image;
use App\Entity\TelegramUser;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testSetAndGetId(): void
    {
        $image = new Image();
        $image->setId(1);

        $this->assertSame(1, $image->getId());
    }

    public function testSetAndGetPath(): void
    {
        $image = new Image();
        $image->setPath('/path/to/image.jpg');

        $this->assertSame('/path/to/image.jpg', $image->getPath());
    }

    public function testSetAndIsProcessed(): void
    {
        $image = new Image();
        $image->setProcessed(true);

        $this->assertTrue($image->isProcessed());
    }

    public function testSetAndGetTelegramUser(): void
    {
        $image = new Image();
        $telegramUser = $this->createMock(TelegramUser::class);

        $image->setTelegramUser($telegramUser);

        $this->assertSame($telegramUser, $image->getTelegramUser());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $image = new Image();
        $now = new \DateTimeImmutable();
        $image->setCreatedAt($now);

        $this->assertSame($now, $image->getCreatedAt());
    }

    public function testSetAndGetUpdatedAt(): void
    {
        $image = new Image();
        $now = new \DateTimeImmutable();
        $image->setUpdatedAt($now);

        $this->assertSame($now, $image->getUpdatedAt());
    }

    public function testSetCreatedAtValue(): void
    {
        $image = new Image();
        $image->setCreatedAtValue();

        $this->assertInstanceOf(\DateTimeImmutable::class, $image->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $image->getUpdatedAt());
    }

    public function testSetUpdatedAtValue(): void
    {
        $image = new Image();
        $image->setUpdatedAtValue();

        $this->assertInstanceOf(\DateTimeImmutable::class, $image->getUpdatedAt());
    }
}
