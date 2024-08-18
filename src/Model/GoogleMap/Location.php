<?php

declare(strict_types=1);

namespace App\Model\GoogleMap;

class Location
{
    private Coordinate $latLng;

    public function getLatLng(): Coordinate
    {
        return $this->latLng;
    }

    public function setLatLng(Coordinate $latLng): static
    {
        $this->latLng = $latLng;

        return $this;
    }
}
