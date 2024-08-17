<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Builder\LocationBuilder;
use App\Entity\Location;
use App\Entity\TelegramUser;
use PHPUnit\Framework\TestCase;

class LocationBuilderTest extends TestCase
{
    public function testBuildCreatesLocation(): void
    {
        $telegramUser = new TelegramUser();
        $address = 'Test Address';
        $builder = new LocationBuilder();

        $location = $builder->build($telegramUser, $address);

        $this->assertInstanceOf(Location::class, $location);
        $this->assertSame($telegramUser, $location->getTelegramUser());
        $this->assertSame($address, $location->getAddress());
    }

    public function testBuildWithEmptyAddress(): void
    {
        $telegramUser = new TelegramUser();
        $address = '';
        $builder = new LocationBuilder();

        $location = $builder->build($telegramUser, $address);

        $this->assertSame($address, $location->getAddress());
    }

    public function testBuildWithNullTelegramUser(): void
    {
        $address = 'Test Address';
        $builder = new LocationBuilder();

        $this->expectException(\TypeError::class);
        $builder->build(null, $address);
    }
}
