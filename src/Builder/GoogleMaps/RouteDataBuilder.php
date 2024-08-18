<?php

declare(strict_types=1);

namespace App\Builder\GoogleMaps;

use App\Model\GoogleMap\Coordinate;
use App\Model\GoogleMap\Destination;
use App\Model\GoogleMap\Location;
use App\Model\GoogleMap\Origin;
use App\Model\GoogleMap\RouteData;

class RouteDataBuilder
{
    private RouteData $routeData;

    public function __construct()
    {
        $this->routeData = new RouteData();
    }

    public function withOrigin(float $latitude, float $longitude): static
    {
        $this->routeData->setOrigin(
            (new Origin())->setLocation(
                $this->buildLocation($latitude, $longitude)
            )
        );

        return $this;
    }

    public function withDestination(float $latitude, float $longitude): static
    {
        $this->routeData->setDestination(
            (new Destination())->setLocation(
                $this->buildLocation($latitude, $longitude)
            )
        );

        return $this;
    }

    public function withIntermediates(array $intermediates): static
    {
        $this->routeData->setIntermediates($intermediates);

        return $this;
    }

    public function build(): RouteData
    {
        return $this->routeData;
    }

    private function buildLocation(float $latitude, float $longitude): Location
    {
        return (new Location())->setLatLng(
            (new Coordinate())->setLatitude($latitude)->setLongitude($longitude)
        );
    }
}
