<?php

declare(strict_types=1);

namespace App\Tests\Model\GoogleMap;

use App\Model\GoogleMap\Coordinate;
use App\Model\GoogleMap\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testSetAndGetLatLng(): void
    {
        $latitude = 40.712776;
        $longitude = -74.005974;

        $coordinate = (new Coordinate())
            ->setLatitude($latitude)
            ->setLongitude($longitude);

        $location = new Location();
        $location->setLatLng($coordinate);

        $this->assertInstanceOf(Coordinate::class, $location->getLatLng());
        $this->assertEquals($latitude, $location->getLatLng()->getLatitude());
        $this->assertEquals($longitude, $location->getLatLng()->getLongitude());
    }

    public function testMethodChaining(): void
    {
        $latitude = 34.052235;
        $longitude = -118.243683;

        $coordinate = (new Coordinate())
            ->setLatitude($latitude)
            ->setLongitude($longitude);

        $location = (new Location())->setLatLng($coordinate);

        $this->assertInstanceOf(Coordinate::class, $location->getLatLng());
        $this->assertEquals($latitude, $location->getLatLng()->getLatitude());
        $this->assertEquals($longitude, $location->getLatLng()->getLongitude());
    }
}
