<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\TelegramUser;
use Luzrain\TelegramBotApi\Type\User;

interface TelegramUserManagerInterface
{
    public function process(User $user): TelegramUser;
}
