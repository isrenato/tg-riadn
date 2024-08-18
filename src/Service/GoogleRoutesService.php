<?php

declare(strict_types=1);

namespace App\Service;

use yidas\googleMaps\Client;
use yidas\googleMaps\Routes;

class GoogleRoutesService implements GoogleRoutesServiceInterface
{
    public function computeRoutes(array $routeData): array
    {
        return (new Routes())->computeRoutes(
            client: new Client($_ENV['GOOGLE_MAPS_API_KEY']),
            origin: null,
            destination: null,
            body: $routeData,
            fieldMask: ['routes.optimizedIntermediateWaypointIndex'],
        );
    }
}
