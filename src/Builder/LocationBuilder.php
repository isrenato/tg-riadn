<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Location;
use App\Entity\TelegramUser;

class LocationBuilder
{
    public function build(TelegramUser $telegramUser, string $address): Location
    {
        return (new Location())
            ->setTelegramUser($telegramUser)
            ->setAddress($address);
    }
}
