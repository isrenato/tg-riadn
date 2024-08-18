<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Location as LocationEntity;
use Luzrain\TelegramBotApi\Type\Message;

interface LocationManagerInterface
{
    public function process(Message $message): string;
}
