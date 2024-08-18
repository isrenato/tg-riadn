<?php

declare(strict_types=1);

namespace App\Manager;

use App\Builder\GoogleMaps\PostalAddressBuilder;
use App\Builder\GoogleMaps\RouteDataBuilder;
use App\Entity\Location as LocationEntity;
use App\Entity\TelegramUser;
use App\Model\GoogleMap\PostalAddress;
use App\Model\GoogleMap\RouteData;
use App\Repository\LocationRepository;
use App\Service\GoogleRoutesServiceInterface;
use Luzrain\TelegramBotApi\Type\Location;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class RouteManager implements RouteManagerInterface
{
    private array $points = [];

    public function __construct(
        private GoogleRoutesServiceInterface $googleRoutesService,
        private RouteDataBuilder $routeDataBuilder,
        private PostalAddressBuilder $postalAddressBuilder,
        private LocationRepository $locationRepository,
        private NormalizerInterface $objectNormalizer,
        private ManagerInterface $manager
    ) {
    }

    public function process(Location $location, TelegramUser $user): string
    {
        $routeData = $this->objectNormalizer->normalize($this->prepareRouteData($location, $user));
        $response = $this->googleRoutesService->computeRoutes($routeData);

        return $this->processArrangement($response);
    }

    private function preparePostalAddresses(TelegramUser $user): array
    {
        $userLocations = $this->locationRepository->findBy(
            [
                'telegramUser' => $user->getId(),
                'processed' => false,
                'isCurrent' => false,
            ]
        );
        $userLocations = array_map(
            fn (LocationEntity $userLocation): PostalAddress => $this->processLocation($userLocation),
            $userLocations
        );
        $this->manager->update();

        return $userLocations;
    }

    private function processLocation(LocationEntity $location): PostalAddress
    {
        array_push($this->points, $location->getAddress());
        $postalAddress = $this->postalAddressBuilder->build($location->getAddress());
        $location->setProcessed(true);

        return $postalAddress;
    }

    private function prepareRouteData(Location $location, TelegramUser $user): RouteData
    {
        $intermediates = $this->preparePostalAddresses($user);

        return $this->routeDataBuilder->withOrigin($location->latitude, $location->longitude)
            ->withIntermediates($intermediates)
            ->withDestination($location->latitude, $location->longitude)
            ->build();
    }

    private function processArrangement(array $data): string
    {
        $waypointIndex = $data['routes'][0]['optimizedIntermediateWaypointIndex'];

        $sortedData = [];
        foreach ($waypointIndex as $key) {
            if (array_key_exists($key, $this->points)) {
                $sortedData[$key] = $this->points[$key];
            }
        }

        return implode(PHP_EOL, $sortedData);
    }
}
