<?php

declare(strict_types=1);

namespace App\Manager;

use App\Builder\LocationBuilder;
use App\Entity\Location as LocationEntity;
use App\Repository\TelegramUserRepository;
use Luzrain\TelegramBotApi\Type\Message;

class LocationManager implements LocationManagerInterface
{
    public function __construct(
        private TelegramUserRepository $userRepository,
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
        $this->manager->create($userLocation);

        return $userLocation;
    }
}
