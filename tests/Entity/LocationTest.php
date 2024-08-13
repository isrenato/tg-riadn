<?php

declare(strict_types=1);

use App\Entity\Location;
use App\Entity\TelegramUser;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testLocationCreation()
    {
        $location = new Location();
        $this->assertInstanceOf(Location::class, $location);
    }

    public function testSetAndGetAddress()
    {
        $location = new Location();
        $address = '123 Main St, Anytown, USA';
        $location->setAddress($address);
        $this->assertEquals($address, $location->getAddress());
    }

    public function testSetAndGetTelegramUser()
    {
        $location = new Location();
        $telegramUser = new TelegramUser(); // Assuming you have a TelegramUser entity
        $location->setTelegramUser($telegramUser);
        $this->assertSame($telegramUser, $location->getTelegramUser());
    }

    public function testSetAndGetProcessed()
    {
        $location = new Location();
        $location->setProcessed(true);
        $this->assertTrue($location->isProcessed());

        $location->setProcessed(false);
        $this->assertFalse($location->isProcessed());
    }

    public function testSetAndGetCurrent()
    {
        $location = new Location();
        $location->setCurrent(true);
        $this->assertTrue($location->isCurrent());

        $location->setCurrent(false);
        $this->assertFalse($location->isCurrent());
    }

    public function testSetAndGetId()
    {
        $location = new Location();
        $location->setId(1);
        $this->assertEquals(1, $location->getId());
    }

    public function testDefaultValues()
    {
        $location = new Location();
        $this->assertNull($location->getId());
        $this->assertNull($location->getAddress());
        $this->assertNull($location->getTelegramUser());
        $this->assertFalse($location->isProcessed());
        $this->assertFalse($location->isCurrent());
    }
}
