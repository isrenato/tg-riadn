<?php

declare(strict_types=1);

namespace App\Tests\Model\GoogleMap;

use App\Model\GoogleMap\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    public function testSetAndGetLatitude(): void
    {
        $latitude = 34.052235;

        $coordinate = new Coordinate();
        $coordinate->setLatitude($latitude);

        $this->assertEquals($latitude, $coordinate->getLatitude());
    }

    public function testSetAndGetLongitude(): void
    {
        $longitude = -118.243683;

        $coordinate = new Coordinate();
        $coordinate->setLongitude($longitude);

        $this->assertEquals($longitude, $coordinate->getLongitude());
    }

    public function testSetLatitudeWithExtremeValues(): void
    {
        $coordinate = new Coordinate();

        $coordinate->setLatitude(-90.0);
        $this->assertEquals(-90.0, $coordinate->getLatitude());

        $coordinate->setLatitude(90.0);
        $this->assertEquals(90.0, $coordinate->getLatitude());
    }

    public function testSetLongitudeWithExtremeValues(): void
    {
        $coordinate = new Coordinate();

        $coordinate->setLongitude(-180.0);
        $this->assertEquals(-180.0, $coordinate->getLongitude());

        $coordinate->setLongitude(180.0);
        $this->assertEquals(180.0, $coordinate->getLongitude());
    }

    public function testMethodChaining(): void
    {
        $latitude = 40.712776;
        $longitude = -74.005974;

        $coordinate = (new Coordinate())
            ->setLatitude($latitude)
            ->setLongitude($longitude);

        $this->assertEquals($latitude, $coordinate->getLatitude());
        $this->assertEquals($longitude, $coordinate->getLongitude());
    }
}
