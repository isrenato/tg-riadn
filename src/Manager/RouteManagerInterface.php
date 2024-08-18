<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\TelegramUser;
use Luzrain\TelegramBotApi\Type\Location;

interface RouteManagerInterface
{
    public function process(Location $location, TelegramUser $user): string;
}
