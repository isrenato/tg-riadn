<?php

declare(strict_types=1);

namespace App\Manager;

use App\Builder\LocationBuilder;
use App\Entity\Location as LocationEntity;
use App\Repository\LocationRepository;
use App\Repository\TelegramUserRepository;
use Luzrain\TelegramBotApi\Type\Message;

class LocationManager implements LocationManagerInterface
{
    public function __construct(
        private TelegramUserRepository $userRepository,
        private LocationRepository $locationRepository,
        private ManagerInterface $manager,
        private LocationBuilder $locationBuilder
    ) {
    }

    public function process(Message $message): LocationEntity
    {
        $user = $this->userRepository->findOneBy(['telegramId' => $message->from->id]);
        $userLocation = $this->locationBuilder->build(
            $user,
            sprintf(
                '%s,%s',
                $message->location->latitude,
                $message->location->longitude
            ),
            true
        );
        $this->clearCurrentUserLocation($user->getId());
        $this->manager->create($userLocation);

        return $userLocation;
    }

    private function clearCurrentUserLocation(int $userId): void
    {
        $currentLocation = $this->locationRepository->findOneBy([
            'telegramUser' => $userId,
            'isCurrent' => true,
        ]);

        if (null === $currentLocation) {
            return;
        }

        $this->manager->delete($currentLocation);
    }
}
