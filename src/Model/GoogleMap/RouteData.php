<?php

declare(strict_types=1);

namespace App\Model\GoogleMap;

class RouteData
{
    private const DEFAULT_TRAVEL_MODE = 'DRIVE';

    private const DEFAULT_ROUTING_PREFERENCE = 'TRAFFIC_AWARE';
    private Origin $origin;

    private array $intermediates;

    private Destination $destination;

    private string $travelMode = self::DEFAULT_TRAVEL_MODE;

    private string $routingPreference = self::DEFAULT_ROUTING_PREFERENCE;

    private bool $optimizeWaypointOrder = true;

    public function getOrigin(): Origin
    {
        return $this->origin;
    }

    public function setOrigin(Origin $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getIntermediates(): array
    {
        return $this->intermediates;
    }

    public function setIntermediates(array $intermediates): static
    {
        $this->intermediates = $intermediates;

        return $this;
    }

    public function getDestination(): Destination
    {
        return $this->destination;
    }

    public function setDestination(Destination $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getTravelMode(): string
    {
        return $this->travelMode;
    }

    public function setTravelMode(string $travelMode): static
    {
        $this->travelMode = $travelMode;

        return $this;
    }

    public function getRoutingPreference(): string
    {
        return $this->routingPreference;
    }

    public function setRoutingPreference(string $routingPreference): static
    {
        $this->routingPreference = $routingPreference;

        return $this;
    }

    public function isOptimizeWaypointOrder(): bool
    {
        return $this->optimizeWaypointOrder;
    }

    public function setOptimizeWaypointOrder(bool $optimizeWaypointOrder): static
    {
        $this->optimizeWaypointOrder = $optimizeWaypointOrder;

        return $this;
    }
}
