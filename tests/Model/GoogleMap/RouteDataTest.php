<?php

declare(strict_types=1);

namespace App\Tests\Model\GoogleMap;

use App\Model\GoogleMap\Coordinate;
use App\Model\GoogleMap\Destination;
use App\Model\GoogleMap\Location;
use App\Model\GoogleMap\Origin;
use App\Model\GoogleMap\RouteData;
use PHPUnit\Framework\TestCase;

class RouteDataTest extends TestCase
{
    public function testSetAndGetOrigin(): void
    {
        $origin = new Origin();
        $location = (new Location())->setLatLng((new Coordinate())->setLatitude(40.712776)->setLongitude(-74.005974));
        $origin->setLocation($location);

        $routeData = new RouteData();
        $routeData->setOrigin($origin);

        $this->assertInstanceOf(Origin::class, $routeData->getOrigin());
        $this->assertSame($origin, $routeData->getOrigin());
    }

    public function testSetAndGetIntermediates(): void
    {
        $intermediates = ['Point A', 'Point B', 'Point C'];

        $routeData = new RouteData();
        $routeData->setIntermediates($intermediates);

        $this->assertEquals($intermediates, $routeData->getIntermediates());
    }

    public function testSetAndGetDestination(): void
    {
        $destination = new Destination();
        $location = (new Location())->setLatLng((new Coordinate())->setLatitude(34.052235)->setLongitude(-118.243683));
        $destination->setLocation($location);

        $routeData = new RouteData();
        $routeData->setDestination($destination);

        $this->assertInstanceOf(Destination::class, $routeData->getDestination());
        $this->assertSame($destination, $routeData->getDestination());
    }

    public function testSetAndGetTravelMode(): void
    {
        $routeData = new RouteData();
        $this->assertEquals('DRIVE', $routeData->getTravelMode());  // Testing default value

        $routeData->setTravelMode('WALK');
        $this->assertEquals('WALK', $routeData->getTravelMode());
    }

    public function testSetAndGetOptimizeWaypointOrder(): void
    {
        $routeData = new RouteData();
        $this->assertTrue($routeData->isOptimizeWaypointOrder());  // Testing default value

        $routeData->setOptimizeWaypointOrder(false);
        $this->assertFalse($routeData->isOptimizeWaypointOrder());
    }

    public function testMethodChaining(): void
    {
        $origin = new Origin();
        $destination = new Destination();
        $intermediates = ['Point A', 'Point B'];

        $routeData = (new RouteData())
            ->setOrigin($origin)
            ->setDestination($destination)
            ->setIntermediates($intermediates)
            ->setTravelMode('BICYCLE')
            ->setOptimizeWaypointOrder(false);

        $this->assertSame($origin, $routeData->getOrigin());
        $this->assertSame($destination, $routeData->getDestination());
        $this->assertEquals($intermediates, $routeData->getIntermediates());
        $this->assertEquals('BICYCLE', $routeData->getTravelMode());
        $this->assertFalse($routeData->isOptimizeWaypointOrder());
    }
}
