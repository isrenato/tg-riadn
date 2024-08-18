<?php

declare(strict_types=1);

namespace App\Model\GoogleMap;

class Origin
{
    protected Location $location;

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): static
    {
        $this->location = $location;

        return $this;
    }
}
