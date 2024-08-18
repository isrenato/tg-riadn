<?php

declare(strict_types=1);

namespace App\Tests\Builder\GoogleMaps;

use App\Builder\GoogleMaps\RouteDataBuilder;
use App\Model\GoogleMap\Coordinate;
use App\Model\GoogleMap\Destination;
use App\Model\GoogleMap\Location;
use App\Model\GoogleMap\Origin;
use App\Model\GoogleMap\RouteData;
use PHPUnit\Framework\TestCase;

class RouteDataBuilderTest extends TestCase
{
    public function testBuildWithOrigin(): void
    {
        $latitude = 34.052235;
        $longitude = -118.243683;

        $builder = new RouteDataBuilder();
        $routeData = $builder->withOrigin($latitude, $longitude)->build();

        $this->assertInstanceOf(RouteData::class, $routeData);
        $this->assertInstanceOf(Origin::class, $routeData->getOrigin());
        $this->assertInstanceOf(Location::class, $routeData->getOrigin()->getLocation());
        $this->assertInstanceOf(Coordinate::class, $routeData->getOrigin()->getLocation()->getLatLng());
        $this->assertEquals($latitude, $routeData->getOrigin()->getLocation()->getLatLng()->getLatitude());
        $this->assertEquals($longitude, $routeData->getOrigin()->getLocation()->getLatLng()->getLongitude());
    }

    public function testBuildWithDestination(): void
    {
        $latitude = 40.712776;
        $longitude = -74.005974;

        $builder = new RouteDataBuilder();
        $routeData = $builder->withDestination($latitude, $longitude)->build();

        $this->assertInstanceOf(RouteData::class, $routeData);
        $this->assertInstanceOf(Destination::class, $routeData->getDestination());
        $this->assertInstanceOf(Location::class, $routeData->getDestination()->getLocation());
        $this->assertInstanceOf(Coordinate::class, $routeData->getDestination()->getLocation()->getLatLng());
        $this->assertEquals($latitude, $routeData->getDestination()->getLocation()->getLatLng()->getLatitude());
        $this->assertEquals($longitude, $routeData->getDestination()->getLocation()->getLatLng()->getLongitude());
    }

    public function testBuildWithIntermediates(): void
    {
        $intermediates = [
            (new Location())->setLatLng(
                (new Coordinate())->setLatitude(37.774929)->setLongitude(-122.419418)
            ),
            (new Location())->setLatLng(
                (new Coordinate())->setLatitude(36.169941)->setLongitude(-115.139832)
            ),
        ];

        $builder = new RouteDataBuilder();
        $routeData = $builder->withIntermediates($intermediates)->build();

        $this->assertInstanceOf(RouteData::class, $routeData);
        $this->assertEquals($intermediates, $routeData->getIntermediates());
    }

    public function testBuildWithOriginDestinationAndIntermediates(): void
    {
        $originLat = 34.052235;
        $originLng = -118.243683;
        $destinationLat = 40.712776;
        $destinationLng = -74.005974;

        $intermediates = [
            (new Location())->setLatLng(
                (new Coordinate())->setLatitude(37.774929)->setLongitude(-122.419418)
            ),
            (new Location())->setLatLng(
                (new Coordinate())->setLatitude(36.169941)->setLongitude(-115.139832)
            ),
        ];

        $builder = new RouteDataBuilder();
        $routeData = $builder
            ->withOrigin($originLat, $originLng)
            ->withDestination($destinationLat, $destinationLng)
            ->withIntermediates($intermediates)
            ->build();

        // Verify Origin
        $this->assertInstanceOf(RouteData::class, $routeData);
        $this->assertEquals($originLat, $routeData->getOrigin()->getLocation()->getLatLng()->getLatitude());
        $this->assertEquals($originLng, $routeData->getOrigin()->getLocation()->getLatLng()->getLongitude());

        // Verify Destination
        $this->assertEquals($destinationLat, $routeData->getDestination()->getLocation()->getLatLng()->getLatitude());
        $this->assertEquals($destinationLng, $routeData->getDestination()->getLocation()->getLatLng()->getLongitude());

        $this->assertEquals($intermediates, $routeData->getIntermediates());
    }

    public function testBuildWithExtremeCoordinates(): void
    {
        $originLat = -90.0;
        $originLng = -180.0;
        $destinationLat = 90.0;
        $destinationLng = 180.0;

        $builder = new RouteDataBuilder();
        $routeData = $builder
            ->withOrigin($originLat, $originLng)
            ->withDestination($destinationLat, $destinationLng)
            ->build();

        $this->assertEquals($originLat, $routeData->getOrigin()->getLocation()->getLatLng()->getLatitude());
        $this->assertEquals($originLng, $routeData->getOrigin()->getLocation()->getLatLng()->getLongitude());

        $this->assertEquals($destinationLat, $routeData->getDestination()->getLocation()->getLatLng()->getLatitude());
        $this->assertEquals($destinationLng, $routeData->getDestination()->getLocation()->getLatLng()->getLongitude());
    }
}
