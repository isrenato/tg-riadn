<?php

declare(strict_types=1);

namespace App\Tests\Model\GoogleMap;

use App\Model\GoogleMap\Coordinate;
use App\Model\GoogleMap\Location;
use App\Model\GoogleMap\Origin;
use PHPUnit\Framework\TestCase;

class OriginTest extends TestCase
{
    public function testSetAndGetLocation(): void
    {
        $latitude = 51.507351;
        $longitude = -0.127758;

        $coordinate = (new Coordinate())
            ->setLatitude($latitude)
            ->setLongitude($longitude);

        $location = (new Location())->setLatLng($coordinate);

        $origin = new Origin();
        $origin->setLocation($location);

        $this->assertInstanceOf(Location::class, $origin->getLocation());
        $this->assertEquals($latitude, $origin->getLocation()->getLatLng()->getLatitude());
        $this->assertEquals($longitude, $origin->getLocation()->getLatLng()->getLongitude());
    }

    public function testMethodChaining(): void
    {
        $latitude = 48.856613;
        $longitude = 2.352222;

        $coordinate = (new Coordinate())
            ->setLatitude($latitude)
            ->setLongitude($longitude);

        $location = (new Location())->setLatLng($coordinate);

        $origin = (new Origin())->setLocation($location);

        $this->assertInstanceOf(Location::class, $origin->getLocation());
        $this->assertEquals($latitude, $origin->getLocation()->getLatLng()->getLatitude());
        $this->assertEquals($longitude, $origin->getLocation()->getLatLng()->getLongitude());
    }
}
